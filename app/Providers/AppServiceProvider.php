<?php

namespace App\Providers;

use App\Models\Commission;
use App\Models\Delivery;
use App\Models\Message;
use App\Models\Report;
use App\Models\Voucher;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Shopper\Facades\Shopper;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\SidebarBuilder;

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
        //
    }
}
