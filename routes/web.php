<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/sandbox', function () {
    return view('sandbox');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
    Route::get('/add', [ProductController::class, 'addView'])->name('shop.add');
    Route::post('/add', [ProductController::class, 'addStore']);
    Route::get('/edit', [ProductController::class, 'editView'])->name('product.edit');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit.view');
    Route::post('/edit/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.delete');
});

require __DIR__.'/auth.php';
