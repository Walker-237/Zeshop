<x-shopper::container class="py-5">
    <x-shopper::heading class="mb-6" title="Commissions">
        <x-slot name="description">
            Track seller commission amounts, payment state, and order references.
        </x-slot>
        @can('create', \App\Models\Commission::class)
            <x-slot name="action">
                <x-shopper::buttons.primary :link="route('shopper.commissions.create')">
                    Add Commission
                </x-shopper::buttons.primary>
            </x-slot>
        @endcan
    </x-shopper::heading>

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Commissions</p>
            <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ $summary['total'] }}</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending</p>
            <p class="mt-2 text-2xl font-semibold text-warning-600">{{ $summary['pending'] }}</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">${{ number_format($summary['pending_amount'], 2) }}</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Paid</p>
            <p class="mt-2 text-2xl font-semibold text-success-600">{{ $summary['paid'] }}</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">${{ number_format($summary['paid_amount'], 2) }}</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cancelled</p>
            <p class="mt-2 text-2xl font-semibold text-danger-600">{{ $summary['cancelled'] }}</p>
        </x-shopper::card>
    </div>

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
