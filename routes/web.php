<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerchantController;

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


// Define a group of routes with 'auth' middleware applied
Route::middleware(['auth'])->group(function () {
    // Define a GET route for the root URL ('/')
    Route::get('/', function () {
        // Return a view named 'index' when accessing the root URL
        return view('index');
    });

    Route::get('/edit/profile', [HomeController::class, 'editProfile'])->name('edit.profile');
    Route::put('/update/profile', [HomeController::class, 'updateProfile'])->name('update.profile');



    // Define a GET route with dynamic placeholders for route parameters
    // Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
    
    Route::middleware(['role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
        Route::controller(MerchantController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/list', 'list')->name('list');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::patch('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
    });
});