<x-shopper::container class="py-5">
    <x-shopper::heading class="mb-6" title="Deliveries">
        <x-slot name="description">
            Assign orders to delivery people and track fulfillment progress.
        </x-slot>
        @can('create', \App\Models\Delivery::class)
            <x-slot name="action">
                <x-shopper::buttons.primary :link="route('shopper.deliveries.create')">
                    Add Delivery
                </x-shopper::buttons.primary>
            </x-slot>
        @endcan
    </x-shopper::heading>

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Deliveries</p>
            <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ $summary['total'] }}</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Assignment</p>
            <p class="mt-2 text-2xl font-semibold text-warning-600">{{ $summary['pending'] }}</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $summary['scheduled_today'] }} scheduled today</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">In Progress</p>
            <p class="mt-2 text-2xl font-semibold text-info-600">{{ $summary['in_progress'] }}</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Delivered</p>
            <p class="mt-2 text-2xl font-semibold text-success-600">{{ $summary['delivered'] }}</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $summary['failed'] }} failed</p>
        </x-shopper::card>
    </div>

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
