<x-shopper::container class="py-5">
    <x-shopper::heading class="mb-6" title="Inventory">
        <x-slot name="description">
            Track stock locations, product coverage, and recent stock movements.
        </x-slot>
        <x-slot name="action">
            @can('add_inventories')
                <x-shopper::buttons.primary :link="route('shopper.settings.locations.create')">
                    Add Location
                </x-shopper::buttons.primary>
            @endcan
        </x-slot>
    </x-shopper::heading>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-shopper::card class="p-5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Stock</p>
            <p class="mt-2 text-3xl font-bold text-gray-950 dark:text-white">{{ number_format($totalStock) }}</p>
        </x-shopper::card>

        <x-shopper::card class="p-5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Locations</p>
            <p class="mt-2 text-3xl font-bold text-gray-950 dark:text-white">{{ number_format($inventories->count()) }}</p>
        </x-shopper::card>

        <x-shopper::card class="p-5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Products</p>
            <p class="mt-2 text-3xl font-bold text-gray-950 dark:text-white">{{ number_format($productCount) }}</p>
        </x-shopper::card>

        <x-shopper::card class="p-5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Variants</p>
            <p class="mt-2 text-3xl font-bold text-gray-950 dark:text-white">{{ number_format($variantCount) }}</p>
        </x-shopper::card>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="font-heading text-lg font-semibold text-gray-950 dark:text-white">Stock Locations</h3>
                <x-shopper::link :href="route('shopper.settings.locations')" class="text-sm font-medium text-primary-600 dark:text-primary-500">
                    Manage locations
                </x-shopper::link>
            </div>

            <x-shopper::card class="overflow-hidden">
                <ul class="divide-y divide-gray-200 dark:divide-white/10">
                    @forelse ($inventories as $inventory)
                        <li class="p-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="truncate text-sm font-semibold text-gray-950 dark:text-white">
                                            {{ $inventory->name }}
                                        </p>
                                        @if ($inventory->is_default)
                                            <x-filament::badge color="gray">Default</x-filament::badge>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $inventory->city }}
                                        @if ($inventory->country)
                                            , {{ $inventory->country->name }}
                                        @endif
                                    </p>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="text-2xl font-bold text-gray-950 dark:text-white">
                                        {{ number_format((int) ($inventory->stock_on_hand ?? 0)) }}
                                    </p>
                                    <p class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">units on hand</p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="p-6 text-sm text-gray-500 dark:text-gray-400">
                            No inventory locations have been created yet.
                        </li>
                    @endforelse
                </ul>
            </x-shopper::card>
        </div>

        <div>
            <h3 class="mb-3 font-heading text-lg font-semibold text-gray-950 dark:text-white">Low Stock</h3>
            <x-shopper::card class="overflow-hidden">
                <ul class="divide-y divide-gray-200 dark:divide-white/10">
                    @forelse ($lowStockProducts as $product)
                        <li class="p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-gray-950 dark:text-white">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Safety stock: {{ $product->security_stock }}</p>
                                </div>
                                <x-filament::badge color="warning">
                                    {{ (int) ($product->stock_on_hand ?? 0) }}
                                </x-filament::badge>
                            </div>
                        </li>
                    @empty
                        <li class="p-6 text-sm text-gray-500 dark:text-gray-400">
                            No products are below their safety stock.
                        </li>
                    @endforelse
                </ul>
            </x-shopper::card>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="mb-3 font-heading text-lg font-semibold text-gray-950 dark:text-white">Recent Stock Movements</h3>
        <x-shopper::card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Item</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Location</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Event</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Quantity</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                        @forelse ($recentMovements as $movement)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-950 dark:text-white">
                                    {{ $movement->stockable?->name ?? class_basename($movement->stockable_type) . ' #' . $movement->stockable_id }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $movement->inventory?->name ?? 'Unknown location' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $movement->event ?? 'Manual adjustment' }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-medium">
                                    <span @class([
                                        'text-success-600 dark:text-success-500' => $movement->quantity >= 0,
                                        'text-danger-600 dark:text-danger-500' => $movement->quantity < 0,
                                    ])>
                                        {{ $movement->quantity >= 0 ? '+' : '' }}{{ number_format($movement->quantity) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right text-sm text-gray-500 dark:text-gray-400">
                                    {{ $movement->created_at?->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-sm text-gray-500 dark:text-gray-400">
                                    No stock movements have been recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-shopper::card>
    </div>
</x-shopper::container>
