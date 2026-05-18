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
    public function boot(): void
    {
        $source = base_path('vendor/shopper/framework/public/images');
        $destination = public_path('cpanel/images');

        if (is_dir($source)) {
            \Illuminate\Support\Facades\File::copyDirectory($source, $destination);
        }
    }
}
