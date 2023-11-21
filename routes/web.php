<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PageHomeController;

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


Route::group(['middleware'=>'sitesetting'], function() {

    Route::get('/', [PageHomeController::class,'home'])->name('home');

    Route::get('/products', [PageController::class,'products'])->name('products');
    Route::get('/men/{slug?}', [PageController::class,'products'])->name('menproducts');
    Route::get('/women/{slug?}', [PageController::class,'products'])->name('womenproducts');
    Route::get('/child/{slug?}', [PageController::class,'products'])->name('childproducts');
    Route::get('/discounted-product', [PageController::class,'products'])->name('discountedproduct');


    Route::get('/product/{slug}', [PageController::class,'productdetail'])->name('product.detail');

    Route::get('/about', [PageController::class,'about'])->name('about');

    Route::get('/contact', [PageController::class,'contact'])->name('contact');

    Route::post('/contact/save', [AjaxController::class,'contactsave'])->name('contact.save');

    Route::get('/cart', [CartController::class,'index'])->name('cart');
    Route::get('/cart/form', [CartController::class,'cartform'])->name('cart.form');

    Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class,'remove'])->name('cart.remove');
    Route::post('/cart/couponcheck', [CartController::class,'couponcheck'])->name('coupon.check');
    Route::post('/cart/newqty', [CartController::class,'newqty'])->name('cart.newqty');
    Route::post('/cart/save', [CartController::class,'cartSave'])->name('cart.cartsave');


    Auth::routes();


    Route::get('/logout', [AjaxController::class,'logout'])->name('cikis');
});

