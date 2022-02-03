<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('products', 'App\Http\Controllers\ProductsController');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'cart'])->name('cart');
Route::post('/addtocart', [App\Http\Controllers\CartController::class, 'addtocart'])->name('addtocart');
Route::get('/addtocart', function(){
    return redirect('/products');
});
Route::post('/removefromcart', [App\Http\Controllers\CartController::class, 'removefromcart'])->name('removefromcart');
Route::get('/removefromcart', function(){
    return redirect('/products');
});

Route::post('/editproductquantity', [App\Http\Controllers\CartController::class, 'editproductquantity'])->name('editproductquantity');
Route::get('/editproductquantity', function(){
    return redirect('/products');
});

Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
Route::post('/placeorder', [App\Http\Controllers\CartController::class, 'placeorder'])->name('placeorder');
Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'payment'])->name('payment');
Route::get('/verifypayment/{transaction_id}', [App\Http\Controllers\PaymentController::class, 'verifypayment'])->name('verifypayment');
Route::get('/completepayment', [App\Http\Controllers\PaymentController::class, 'completepayment'])->name('completepayment');
Route::get('/thankyou', [App\Http\Controllers\PaymentController::class, 'thankyou'])->name('thankyou');