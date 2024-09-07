<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Cviebrock\EloquentSluggable\Services\SlugService;

class MenuController extends Controller
{
    public function list(Request $request) {
        $menus = Menu::where('merchant_id', auth()->user()->merchant->id);

        if ($request->ajax()) {
            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('type', function ($row) {
                    return $row->type;
                })
                ->addColumn('price', function ($row) {
                    return $row->price;
                })
                ->addColumn('action', function ($row) {
                    $id = encrypt($row->id);
                    $detailUrl = route('merchant.menu.edit', ['id' => $id]);
                    return '
                        <div class="text-center">
                            <a class="text-warning me-2" type="button" href="' . $detailUrl . '" title="Ubah Data"><i class="fa-solid fa-pencil"></i></a>
                            <a class="text-danger btn-delete" type="button" title="Hapus Data" data-id="' . $id . '"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return DataTables::queryBuilder($menus)->toJson();
    }

    public function create() {
        return view('home.merchant.menu.create');
    }

    public function store(Request $request) {
        // return $request->all(); 

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:menus',
            'type' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $menu = Menu::create([
            'merchant_id' => auth()->user()->merchant->id,
            'name' => $request->name,
            'slug' => $request->slug,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // store image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $menu->slug . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/menu'), $imageName);
            $menu->image = $imageName;
            $menu->save();
        }

        return redirect()->route('merchant.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function checkSlug(Request $request) {
        $slug = SlugService::createSlug(Menu::class, 'slug', $request->name ?? '');
        return response()->json(['slug' => $slug]);
    }

    public function edit($id) {
        $id = decrypt($id);
        $menu = Menu::find($id);
        return view('home.merchant.menu.edit', compact('menu'));
    }

    public function update(Request $request) {
        $id = decrypt($request->id);
        $menu = Menu::find($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:menus,slug,' . $menu->id,
            'type' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $menu->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // store image
        if ($request->hasFile('image')) {
            $imagePath = public_path('images/menu/' . $menu->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $image = $request->file('image');
            $imageName = $menu->slug . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/menu'), $imageName);
            $menu->image = $imageName;
            $menu->save();
        }

        return redirect()->route('merchant.index')->with('success', 'Menu berhasil diubah!');
    }

    public function delete(Request $request) {
        $id = decrypt($request->id);
        $menu = Menu::find($id);
        $menu->delete();

        if ($menu->image) {
            $imagePath = public_path('images/menu/' . $menu->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        return response()->json([
            'success' => TRUE,
            'message' => 'Menu berhasil dihapus!',
        ]);
    }
}