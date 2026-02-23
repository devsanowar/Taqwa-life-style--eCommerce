<?php

use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Frontend\ProductSearchController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductDetailsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Search Product
Route::get('/search', [ProductSearchController::class, 'search'])->name('product.search');
Route::get('/search-suggest', [ProductSearchController::class, 'searchSuggest'])->name('product.search.suggest');



// Product details
Route::get('product-details/{slug}', [ProductDetailsController::class, 'productDetails'])->name('product.details');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
