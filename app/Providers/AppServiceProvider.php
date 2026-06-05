<?php

namespace App\Providers;

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
    public function boot()
{
    // Esto obliga a Laravel a generar todos los enlaces con HTTPS en Render
    if (config('app.env') === 'production' || env('FORCE_HTTPS') === true) {
        URL::forceScheme('https');
    }
}
}
