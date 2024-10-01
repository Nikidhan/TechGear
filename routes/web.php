<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/{product_slug}', [HomeController::class, 'product_details'])->name('product.details');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard',[UserController::class,'index'])->name('user.index');
});

Route::middleware([AuthAdmin::class])->group(function(){
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');

    Route::get('/admin/products', [AdminController::class,'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class,'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class,'product_store'])->name('admin.product.store');
    Route::get('/admin/product/{id}/edit', [AdminController::class,'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product//update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');
});