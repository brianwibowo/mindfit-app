<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        // Dynamically detect active ngrok tunnel URL and force it as the root URL
        // This prevents CORS and mismatch errors if the active ngrok domain differs from the local .env APP_URL.
        if ($host = request()->header('X-Forwarded-Host')) {
            $proto = request()->header('X-Forwarded-Proto', 'https');
            \Illuminate\Support\Facades\URL::forceRootUrl($proto . '://' . $host);
            \Illuminate\Support\Facades\URL::forceScheme($proto);
        } elseif (str_contains(config('app.url'), 'ngrok') || request()->header('X-Forwarded-Proto') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Use Bootstrap 5 pagination styling globally (instead of Tailwind default)
        Paginator::useBootstrapFive();
    }
}
