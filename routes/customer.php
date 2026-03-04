<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Frontend\Auth\CustomerDashboardController;
use App\Http\Controllers\Frontend\Auth\CustomerForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\CustomerLoginController;
use App\Http\Controllers\Frontend\Auth\CustomerProfileController;
use App\Http\Controllers\Frontend\Auth\CustomerRegisterController;
use App\Http\Controllers\Frontend\Auth\CustomerResetPasswordController;
use App\Http\Controllers\Frontend\Auth\PayPalController;
use App\Http\Controllers\Reseller\ResellerDashboardController;
use App\Http\Controllers\Reseller\ResellerProfileController;
use App\Http\Controllers\Reseller\WebsiteController;
use Illuminate\Support\Facades\Route;


Route::prefix("customer")->group(function () {
    Route::get("signup", [CustomerRegisterController::class, "register"])->name("customer.signup");
    Route::post('/signup', [CustomerRegisterController::class, 'store'])->name('signup.store');

    Route::get("sign-in", [CustomerLoginController::class, "signIn"])->name("customer.signin");
    Route::post('/sign-in', [CustomerLoginController::class, 'login'])->name('login.store');

    // Forgot password form
    // Route::get('customer/password/forgot', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])
    //     ->name('customer.password.request');
    // Send reset link
    // Route::post('customer/password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])
    //     ->name('customer.password.email');

    // Show reset form (with token)
    // Route::get('customer/password/reset/{token}', [CustomerResetPasswordController::class, 'showResetForm'])
    //     ->name('customer.password.reset');

    // Route::post('customer/password/reset', [CustomerResetPasswordController::class, 'reset'])
    //     ->name('customer.password.update');



    Route::middleware(['role:customer'])->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'dashboard'])->name('customer.dashboard');
        // Route::put('/profile/info/update', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
        // Route::put('/profile/image/update', [CustomerProfileController::class, 'profileImageUpdate'])->name('customer.profile.image.update');
        // Route::post('/customer/change-password', [CustomerProfileController::class, 'changePassword'])->name('customer.change.password');
        // Route::delete('/customer/delete/account/{id}', [CustomerProfileController::class, 'destroy'])->name('customer.destroy');
        Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');



        // Route::get('/order/{id}/invoice', [CustomerDashboardController::class, 'invoiceShow'])->name('customer.order.invoice.show');

    });

});


