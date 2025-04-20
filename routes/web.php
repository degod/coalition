<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('product.list');
Route::post('/store', [ProductController::class, 'store'])->name('product.store');
Route::post('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
