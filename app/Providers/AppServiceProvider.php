<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 🔐 FORCE HTTPS (ngrok + Shopify)
        if (app()->environment('local')) {
            URL::forceScheme('https');
        }
    }
}
