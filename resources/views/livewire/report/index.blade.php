<x-shopper::container class="py-5">
    <x-shopper::heading class="mb-6" title="Reports">
        <x-slot name="description">
            Generate and review operational snapshots across sales, commissions, deliveries, and inventory.
        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap items-center gap-3">
                <x-shopper::buttons.default wire:click="exportOverviewCsv">
                    Export CSV
                </x-shopper::buttons.default>
                @can('create', \App\Models\Report::class)
                    <x-shopper::buttons.primary :link="route('shopper.reports.create')">
                        Generate Report
                    </x-shopper::buttons.primary>
                @endcan
            </div>
        </x-slot>
    </x-shopper::heading>

    <div class="mb-6">
        <div class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-heading text-lg font-semibold text-gray-950 dark:text-white">Operational Overview</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $overview['period']['start'] }} to {{ $overview['period']['end'] }}
                </p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-shopper::card class="p-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Orders</p>
                <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ $overview['summary']['orders_count'] }}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">${{ number_format($overview['summary']['average_order_value'], 2) }} average order</p>
            </x-shopper::card>
            <x-shopper::card class="p-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Revenue</p>
                <p class="mt-2 text-2xl font-semibold text-success-600">${{ number_format($overview['summary']['total_revenue'], 2) }}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $overview['summary']['products_count'] }} products tracked</p>
            </x-shopper::card>
            <x-shopper::card class="p-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock On Hand</p>
                <p class="mt-2 text-2xl font-semibold text-info-600">{{ number_format($overview['summary']['stock_on_hand']) }}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $overview['summary']['low_stock_count'] }} low stock products</p>
            </x-shopper::card>
            <x-shopper::card class="p-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Attention</p>
                <p class="mt-2 text-2xl font-semibold text-warning-600">{{ $overview['summary']['unread_messages'] }}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $overview['summary']['deliveries_in_progress'] }} deliveries, ${{ number_format($overview['summary']['pending_commission_amount'], 2) }} commissions
                </p>
            </x-shopper::card>
        </div>
    </div>

    <div class="mb-6 grid gap-6 xl:grid-cols-3">
        <x-shopper::card class="p-5 xl:col-span-2">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 class="font-medium text-gray-900 dark:text-white">Top Products By Sales</h2>
                <span class="text-sm text-gray-500 dark:text-gray-400">Units and revenue</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-white/10">
                    <thead>
                        <tr class="text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                            <th class="py-2 pr-4">Product</th>
                            <th class="py-2 pr-4">SKU</th>
                            <th class="py-2 pr-4">Units</th>
                            <th class="py-2">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse ($overview['top_products'] as $product)
                            <tr>
                                <td class="py-3 pr-4 font-medium text-gray-900 dark:text-white">{{ $product['name'] }}</td>
                                <td class="py-3 pr-4 text-gray-600 dark:text-gray-400">{{ $product['sku'] }}</td>
                                <td class="py-3 pr-4 text-gray-600 dark:text-gray-400">{{ number_format($product['units_sold']) }}</td>
                                <td class="py-3 text-gray-600 dark:text-gray-400">${{ number_format($product['revenue'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-500 dark:text-gray-400">No sales found for this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-shopper::card>

        <x-shopper::card class="p-5">
            <h2 class="mb-4 font-medium text-gray-900 dark:text-white">Orders By Status</h2>
            <div class="space-y-3">
                @forelse ($overview['orders_by_status'] as $status => $count)
                    <div class="flex items-center justify-between gap-4 text-sm">
                        <span class="capitalize text-gray-600 dark:text-gray-400">{{ str_replace('_', ' ', $status) }}</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $count }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">No orders found for this period.</p>
                @endforelse
            </div>
        </x-shopper::card>
    </div>

    <div class="mb-6 grid gap-6 xl:grid-cols-3">
        <x-shopper::card class="p-5 xl:col-span-2">
            <h2 class="mb-4 font-medium text-gray-900 dark:text-white">Recent Stock Movements</h2>
            <div class="space-y-4">
                @forelse ($overview['recent_stock_movements'] as $movement)
                    <div class="flex flex-col gap-1 border-b border-gray-100 pb-4 text-sm last:border-0 last:pb-0 dark:border-white/5">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $movement['product'] }}</span>
                            <span class="text-gray-500 dark:text-gray-400">{{ $movement['created_at'] }}</span>
                        </div>
                        <div class="text-gray-600 dark:text-gray-400">
                            {{ $movement['inventory'] }} - {{ $movement['event'] }} - quantity {{ $movement['quantity'] }}
                        </div>
                        @if ($movement['description'])
                            <div class="text-gray-500 dark:text-gray-400">{{ $movement['description'] }}</div>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">No stock movements recorded yet.</p>
                @endforelse
            </div>
        </x-shopper::card>

        <x-shopper::card class="p-5">
            <h2 class="mb-4 font-medium text-gray-900 dark:text-white">Low Stock Products</h2>
            <div class="space-y-3">
                @forelse ($overview['low_stock_products'] as $product)
                    <div class="flex items-center justify-between gap-4 text-sm">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $product['name'] }}</div>
                            <div class="text-gray-500 dark:text-gray-400">{{ $product['sku'] }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-warning-600">{{ $product['stock_on_hand'] }}</div>
                            <div class="text-gray-500 dark:text-gray-400">min {{ $product['security_stock'] }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">No low stock products right now.</p>
                @endforelse
            </div>
        </x-shopper::card>
    </div>

    @if ($latestReport)
        <x-shopper::card class="mb-6 p-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase text-gray-500 dark:text-gray-400">Latest report</p>
                    <h3 class="mt-1 font-heading text-xl font-semibold text-gray-950 dark:text-white">
                        {{ $latestReport->title }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ ucfirst($latestReport->type) }} generated {{ $latestReport->generated_at->diffForHumans() }}
                    </p>
                </div>
                <dl class="grid gap-3 sm:grid-cols-2 lg:min-w-[24rem]">
                    @foreach (array_slice($latestReport->summary, 0, 4, true) as $label => $value)
                        <div class="rounded-lg bg-gray-50 p-3 dark:bg-white/5">
                            <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                {{ str($label)->replace('_', ' ')->title() }}
                            </dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-950 dark:text-white">
                                {{ is_array($value) ? count($value) : $value }}
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </x-shopper::card>
    @endif

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
