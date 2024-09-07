<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class TransactionController extends Controller
{
    public function invoice() {
        $transactions = auth()->user()->transactions;

        return view('home.transaction.invoice', compact('transactions'));
    }

    public function list() {
        if (auth()->user()->hasRole('merchant')) {
            $transactions = Transaction::selectRaw('user_id, created_at as transaction_date, SUM(total) as total_price')
                ->with('user')
                ->where('merchant_id', auth()->user()->merchant->id)  
                ->groupBy('user_id', 'transaction_date'); // Tambahkan 'transaction_date' pada groupBy
                
        } elseif (auth()->user()->hasRole('customer')) {
            $transactions = Transaction::selectRaw('user_id, created_at as transaction_date, SUM(total) as total_price')
                ->with('user')
                ->where('user_id', auth()->id())
                ->groupBy('user_id', 'transaction_date'); // Tambahkan 'transaction_date' pada groupBy
        }

        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('buyer', function ($row) {
                return $row->user->name; 
            })
            ->addColumn('total', function ($row) {
                return 'Rp' . number_format($row->total_price, 0, ',', '.');
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->user_id);
                $cetakInvoiceUrl = route('transaction.cetak-invoice', ['id' => $id]);
                return '
                    <div class="text-center">
                        <a class="text-success me-2 fs-4" type="button" target="_blank" href="' . $cetakInvoiceUrl . '" title="Cetak Invoice"><i class="fa-solid fa-file-invoice-dollar"></i></a>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function cetakInvoice($id) {
        $transactions = Transaction::where('user_id', decrypt($id))->get();
        $merchant = Merchant::find($transactions[0]->merchant_id);

        // create invoice with LaravelDaily/laravel-invoices
        $invoice = Invoice::make()
            ->buyer(new Buyer([
                'name' => $transactions[0]->user->name,
                'custom_fields' => [
                    'email' => $transactions[0]->user->email,
                    'address' => $transactions[0]->address
                ]
            ]))
            ->discountByPercent(0)
            ->notes($transactions[0]->note ?? '')
            ->filename($transactions[0]->user->name . '-invoice')
            ->currencySymbol('Rp')
            ->currencyCode('IDR')
            ->currencyFormat('{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            // seller
            ->seller(new Party([
                'name' => $merchant->name,
                'custom_fields' => [
                    'email' => $merchant->user->email,
                    'address' => $merchant->address
                ]
            ]));
            
        foreach ($transactions as $transaction) {
            $item = (new InvoiceItem())
                ->title($transaction->menu->name)     // Nama menu
                ->pricePerUnit($transaction->price_per_item)   // Total harga
                ->quantity($transaction->qty);        // Jumlah item
    
            $invoice->addItem($item); // Tambahkan item ke invoice
        }

        return $invoice->stream();
    }
}