<?php

namespace App\Providers;

use App\Models\ThemeCustomizer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $theme = ThemeCustomizer::first();
        View::share('theme', $theme);
    }
}
