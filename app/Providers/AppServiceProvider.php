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
        Event::listen(SidebarBuilder::class, function (SidebarBuilder $sidebar): void {
            $user = Shopper::auth()->user();

            $sidebar->getMenu()->group('Operations', function (Group $group) use ($user): void {
                $group->weight(4);
                $group->setAuthorized();
                $group->setGroupItemsClass('space-y-1');
                $group->setHeadingClass('sh-heading');

                $group->item('Inventory', function (Item $item) use ($user): void {
                    $item->weight(1);
                    $item->setAuthorized($user?->can('browse_inventories') ?? false);
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('shopper.inventory.index');
                    $item->setIcon(
                        icon: 'heroicon-o-archive-box',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });

                $group->item('Commissions', function (Item $item) use ($user): void {
                    $item->weight(2);
                    $item->setAuthorized($user?->can('viewAny', Commission::class) ?? false);
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('shopper.commissions.index');
                    $item->setIcon(
                        icon: 'heroicon-o-currency-dollar',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });

                $group->item('Deliveries', function (Item $item) use ($user): void {
                    $item->weight(3);
                    $item->setAuthorized($user?->can('viewAny', Delivery::class) ?? false);
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('shopper.deliveries.index');
                    $item->setIcon(
                        icon: 'heroicon-o-truck',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });

                $group->item('Reports', function (Item $item) use ($user): void {
                    $item->weight(4);
                    $item->setAuthorized($user?->can('viewAny', Report::class) ?? false);
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('shopper.reports.index');
                    $item->setIcon(
                        icon: 'heroicon-o-chart-bar',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });

                $group->item('Messages', function (Item $item) use ($user): void {
                    $item->weight(5);
                    $item->setAuthorized($user?->can('viewAny', Message::class) ?? false);
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('shopper.messages.index');
                    $item->setIcon(
                        icon: 'heroicon-o-envelope',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });

                $group->item('Vouchers', function (Item $item) use ($user): void {
                    $item->weight(6);
                    $item->setAuthorized($user?->can('viewAny', Voucher::class) ?? false);
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('shopper.vouchers.index');
                    $item->setIcon(
                        icon: 'heroicon-o-receipt-percent',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });
            });
        });
        $source = base_path('vendor/shopper/framework/public/images');
        $destination = public_path('cpanel/images');

        if (is_dir($source)) {
            \Illuminate\Support\Facades\File::copyDirectory($source, $destination);
        }
    }
}
