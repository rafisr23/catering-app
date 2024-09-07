<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function pilihMenu() {
        $menus = Menu::with('merchant')->Filter(request(['search', 'address', 'type']))->paginate(9)->withQueryString();

        return view('home.customer.pilih-menu', compact('menus'));
    }

    public function addToCart(Request $request, $id) {
        $cart = \Cart::session(auth()->id());

        $menu = Menu::findOrFail(decrypt($id));

        $cart->add($menu->id, $menu->name, $menu->price, $request->qty, [
            'merchant' => $menu->merchant->name,
            'merchant_id' => $menu->merchant->id,
            'type' => $menu->type,
            'image' => $menu->image
        ]);

        return redirect()->back()->with('cart-success', 'Menu berhasil ditambahkan ke keranjang');
    }

    public function cart() {
        $cartItems = \Cart::session(auth()->id())->getContent();
        $total = \Cart::session(auth()->id())->getTotal();

        // return $cartItems;

        return view('home.customer.cart', compact('cartItems', 'total'));
    }

    public function storeCart(Request $request) {
        $request->validate([
            'delivery_date' => 'required',
            'address' => 'required'
        ]);

        $cartItems = \Cart::session(auth()->id())->getContent();

        foreach ($cartItems as $item) {
            auth()->user()->transactions()->create([
                'user_id' => auth()->id(),
                'merchant_id' => $item->attributes['merchant_id'],
                'menu_id' => $item->id,
                'qty' => $item->quantity,
                'price_per_item' => $item->price,
                'total' => $item->getPriceSum(),
                'delivery_date' => $request->delivery_date,
                'address' => $request->address,
                'note' => $request->note
            ]);
        }

        \Cart::session(auth()->id())->clear();

        return redirect()->route('customer.cart')->with('success', 'Pesanan berhasil dibuat!');
    }
}