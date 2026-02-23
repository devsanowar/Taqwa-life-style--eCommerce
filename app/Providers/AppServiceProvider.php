<?php

namespace App\Providers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        $categories = ProductCategory::where('status', 1)->get();
        $view->with('categories', $categories);

        ProductCategory::withCount('products')
        ->where('status',1)
        ->get();
    });
    }
}
