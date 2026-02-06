<?php

use App\Models\ProductCategory;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SocialIconController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ThemeCustomerController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Admin\ProductCategoryController;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Profile Management Routes
    Route::prefix('profile')->name('admin.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/image/update', [ProfileController::class, 'updateImage'])->name('image.update');
    });

    // Password Management Route
    Route::prefix('password')->name('admin.password.')->group(function () {
        Route::post('/update', [ProfileController::class, 'changePassword'])->name('update');
    });

    // Website Settings route
    Route::prefix('website-settings')->name('admin.website.setting.')->group(function () {
        Route::get('/', [WebsiteSettingController::class, 'index'])->name('index');
        Route::put('/update', [WebsiteSettingController::class, 'update'])->name('update');
        Route::put('/color-update', [WebsiteSettingController::class, 'websiteColorupdate'])->name('color.update');
    });

    //social control route here
    Route::prefix('social-icon')->name('admin.social.icon.')->group(function () {
        Route::get('/', [SocialIconController::class, 'index'])->name('index');
        Route::put('/update', [SocialIconController::class, 'update'])->name('update');
    });

    // Theme customize route here
    Route::prefix('theme-customize')->name('admin.theme.customize.')->group(function () {
        Route::get('/', [ThemeCustomerController::class, 'index'])->name('index');
        Route::put('/update', [ThemeCustomerController::class, 'update'])->name('update');
    });

    // Website menu routes here
    Route::prefix('website-menu')->name('admin.website.menu.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::post('/store', [MenuController::class, 'store'])->name('store');
        Route::put('/update/{id}', [MenuController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [MenuController::class, 'destroy'])->name('destroy');
    });

    // Product Route here
    Route::prefix('product')->middleware(['auth', 'verified'])->group(function () {
        Route::get('categories', [ProductCategoryController::class, 'index'])->name('admin.product.category.index');
        Route::get('categories/create', [ProductCategoryController::class, 'create'])->name('admin.product.category.create');
        Route::post('categories', [ProductCategoryController::class, 'store'])->name('admin.product.category.store');
        Route::get('categories/{id}/edit', [ProductCategoryController::class, 'edit'])->name('admin.product.category.edit');
        Route::put('categories/{id}', [ProductCategoryController::class, 'update'])->name('admin.product.category.update');
        Route::delete('categories/{id}', [ProductCategoryController::class, 'destroy'])->name('admin.product.category.destroy');

        // Product brand route here
        Route::get('brands', [ProductBrandController::class, 'index'])->name('admin.product.brand.index');
        Route::post('brands/store', [ProductBrandController::class, 'store'])->name('admin.product.brand.store');
        Route::get('brands/edit/{id}', [ProductBrandController::class, 'edit'])->name('admin.product.brand.edit');
        Route::post('brands/update/{id}', [ProductBrandController::class, 'update'])->name('admin.product.brand.update');
        Route::delete('brands/delete/{id}', [ProductBrandController::class, 'destroy'])->name('admin.product.brand.destroy');

        // Product route here
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');

    });



    // Post Category route here
    Route::prefix('post/category')->controller(PostCategoryController::class)->name('admin.post.category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });

    // Post Route here
    Route::prefix('post')->controller(PostController::class)->name('admin.post.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });
});
