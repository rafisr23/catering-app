<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('index');
    });

    Route::get('/edit/profile', [HomeController::class, 'editProfile'])->name('edit.profile');
    Route::put('/update/profile', [HomeController::class, 'updateProfile'])->name('update.profile');
    
    Route::middleware(['role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
        Route::controller(MerchantController::class)->group(function () {
            Route::get('/', 'index')->name('index');
        });
        
        Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/list', 'list')->name('list');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
            Route::get('/check-slug', 'checkSlug')->name('check-slug');
        });
    });
    
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/pilih-menu', 'pilihMenu')->name('pilih-menu');
            Route::post('/add-to-cart/{id}', 'addToCart')->name('add-to-cart');
            Route::get('/cart', 'cart')->name('cart');
            Route::post('/store/cart', 'storeCart')->name('store-cart');
        });
        
    });

    Route::controller(TransactionController::class)->prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::get('/invoice', 'invoice')->name('invoice');
        Route::get('/cetak-invoice/{id}', 'cetakInvoice')->name('cetak-invoice');
    });
});