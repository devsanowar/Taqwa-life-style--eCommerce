<?php

use App\Http\Controllers\Frontend\ProductCategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductDetailsController;
use App\Http\Controllers\Frontend\ProductSearchController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Search Product
Route::get('/search', [ProductSearchController::class, 'search'])->name('product.search');
Route::get('/search-suggest', [ProductSearchController::class, 'searchSuggest'])->name('product.search.suggest');



// Product details
Route::get('product-details/{slug}', [ProductDetailsController::class, 'productDetails'])->name('product.details');

// Cart routes
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('/cart/page', [CartController::class, 'cartPage'])->name('cart.page');
Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.updateQty');
Route::post('/cart/remove', [CartController::class, 'removeItem'])->name('cart.removeItem');

//Wishlist routes
Route::post('/add-to-wishlist', [WishlistController::class, 'add'])->name('addToWishlist');
Route::get('/wishlist/page', [WishlistController::class, 'wishlistPage'])->name('wishlist.page');

// Shop page route
Route::get('/shop/', [ShopController::class, 'shopPage'])->name('shop.page');
Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');

// Product category page route
Route::get('/products', [ProductCategoryController::class, 'index'])->name('products.index');
Route::get('/product/category/{slug}', [ProductCategoryController::class, 'category'])->name('category.page');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
