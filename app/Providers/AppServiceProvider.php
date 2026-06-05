<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 🔴 IMPORTANTE: Esto va aquí arriba

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
        // 🔴 IMPORTANTE: El código que agregamos va dentro de esta función
        if (config('app.env') === 'production' || env('FORCE_HTTPS') === true) {
            URL::forceScheme('https');
        }
    }
}