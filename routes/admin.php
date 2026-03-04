<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\FlashSaleItemController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SocialIconController;
use App\Http\Controllers\Admin\ThemeCustomerController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['role:admin,super_admin'])->group(function () {

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
    Route::prefix('product')->group(function () {
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



        // Atribute route here
        Route::get('attributes', [AttributeController::class, 'index'])->name('admin.product.attribute.index');
        Route::get('attributes/create', [AttributeController::class, 'create'])->name('admin.product.attribute.create');
        Route::post('attributes', [AttributeController::class, 'store'])->name('admin.product.attribute.store');
        Route::get('attributes/{id}/edit', [AttributeController::class, 'edit'])->name('admin.product.attribute.edit');
        Route::put('attributes/{id}', [AttributeController::class, 'update'])->name('admin.product.attribute.update');
        Route::delete('attributes/{id}', [AttributeController::class, 'destroy'])->name('admin.product.attribute.destroy');

        // Attribute Values route here
        Route::get('attribute-values', [AttributeValueController::class, 'index'])->name('admin.product.attribute_value.index');
        Route::get('attribute-values/create', [AttributeValueController::class, 'create'])->name('admin.product.attribute_value.create');
        Route::post('attribute-values', [AttributeValueController::class, 'store'])->name('admin.product.attribute_value.store');
        Route::get('attribute-values/{id}/edit', [AttributeValueController::class, 'edit'])->name('admin.product.attribute_value.edit');
        Route::put('attribute-values/{id}', [AttributeValueController::class, 'update'])->name('admin.product.attribute_value.update');
        Route::delete('attribute-values/{id}', [AttributeValueController::class, 'destroy'])->name('admin.product.attribute_value.destroy');


        // Product variant route here
        Route::get('/variants', [ProductVariantController::class, 'index'])->name('admin.product.variants.index');
        Route::get('/variants/create', [ProductVariantController::class, 'create'])->name('admin.product.variants.create');
        Route::post('/variants/store', [ProductVariantController::class, 'storeVariant'])->name('admin.product.variants.store');
        Route::get('/variants/edit/{id}', [ProductVariantController::class, 'editVariant'])->name('admin.product.variants.edit');
        Route::put('/variants/update/{id}', [ProductVariantController::class, 'updateVariant'])->name('admin.product.variants.update');
        Route::delete('/variants/delete/{id}', [ProductVariantController::class, 'destroyVariant'])->name('admin.product.variants.destroy');

        // Flash Sale route here
        Route::get('flash-sales/', [FlashSaleController::class, 'index'])->name('admin.flash_sales.index');
        Route::get('flash-sales/create', [FlashSaleController::class, 'create'])->name('admin.flash_sales.create');
        Route::post('flash-sales/store', [FlashSaleController::class, 'store'])->name('admin.flash_sales.store');
        Route::get('flash-sales/edit/{id}', [FlashSaleController::class, 'edit'])->name('admin.flash_sales.edit');
        Route::post('flash-sales/update/{id}', [FlashSaleController::class, 'update'])->name('admin.flash_sales.update');
        Route::delete('flash-sales/delete/{id}', [FlashSaleController::class, 'destroy'])->name('admin.flash_sales.destroy');

        // Flash sale item route here
        Route::get('/flash-sales/items', [FlashSaleItemController::class, 'index'])->name('admin.flash_sale_items.index');
        Route::get('/flash-sales/items/create', [FlashSaleItemController::class, 'create'])->name('admin.flash_sale_items.create');
        Route::post('/flash-items/store', [FlashSaleItemController::class, 'store'])->name('admin.flash_sale_items.store');
        Route::get('/flash-items/edit/{item}', [FlashSaleItemController::class, 'edit'])->name('admin.flash_sale_items.edit');
        Route::post('/flash-items/update/{item}', [FlashSaleItemController::class, 'update'])->name('admin.flash_sale_items.update');
        Route::delete('/flash-items/delete/{item}', [FlashSaleItemController::class, 'destroy'])->name('admin.flash_sale_items.delete');


        Route::prefix('inventory')->group(function () {

            Route::post('/reserve', [InventoryController::class, 'reserve']);
            Route::post('/commit', [InventoryController::class, 'commit']);
            Route::post('/release', [InventoryController::class, 'release']);
        });

        Route::prefix('review')->name('admin.product.')->group(function () {
            Route::get('/', [ProductReviewController::class, 'index'])->name('review.index');
            Route::get('/create', [ProductReviewController::class, 'create'])->name('review.create');
            Route::post('/store', [ProductReviewController::class, 'store'])->name('review.store');
            Route::get('/edit/{id}', [ProductReviewController::class, 'edit'])->name('review.edit');
            Route::put('/update/{id}', [ProductReviewController::class, 'update'])->name('review.update');
            Route::put('/delete/{id}', [ProductReviewController::class, 'destroy'])->name('review.destroy');
        });
    });

    Route::prefix('home')->name('admin.home.')->group(function () {
        Route::get('slider', [SliderController::class, 'index'])->name('slider.index');
        Route::get('slider/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('slider/store', [SliderController::class, 'store'])->name('slider.store');
        Route::get('slider/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('slider/update/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('slider/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
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
