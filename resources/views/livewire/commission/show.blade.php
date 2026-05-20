<x-shopper::container class="py-5">
    <x-shopper::breadcrumb
        :back="route('shopper.commissions.index')"
        current="Commission Details"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.commissions.index')"
            title="Commissions"
        />
    </x-shopper::breadcrumb>

    <div class="my-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <x-shopper::heading class="mb-0" title="Commission Details">
            <x-slot name="description">
                {{ $commission->order?->number ?? 'No order' }} - {{ $commission->seller?->full_name ?? 'Unassigned seller' }}
            </x-slot>
        </x-shopper::heading>

        <div class="flex flex-wrap items-center gap-3">
            @can('update', $commission)
                <x-shopper::buttons.default :link="route('shopper.commissions.edit', $commission)">
                    Edit
                </x-shopper::buttons.default>
                @if ($commission->status !== 'paid')
                    <x-shopper::buttons.primary wire:click="markPaid">
                        Mark Paid
                    </x-shopper::buttons.primary>
                @endif
                @if ($commission->status !== 'cancelled')
                    <x-shopper::buttons.default wire:click="cancel">
                        Cancel Commission
                    </x-shopper::buttons.default>
                @endif
            @endcan
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <x-shopper::card class="p-6 lg:col-span-2">
            <dl class="grid gap-5 text-sm sm:grid-cols-2">
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Seller</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $commission->seller?->full_name ?? 'Unassigned' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Order</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $commission->order?->number ?? 'No order' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Amount</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">${{ number_format((float) $commission->amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Rate</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $commission->rate }}%</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Status</dt>
                    <dd class="mt-1 capitalize text-gray-600 dark:text-gray-400">{{ $commission->status }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Paid At</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $commission->paid_at?->format('M j, Y g:i A') ?? 'Not paid' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Payment Reference</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $commission->payment_reference ?? 'Not specified' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Created</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $commission->created_at?->format('M j, Y g:i A') }}</dd>
                </div>
            </dl>
        </x-shopper::card>

        <x-shopper::card class="p-6">
            <h2 class="font-medium text-gray-900 dark:text-white">Notes</h2>
            <p class="mt-3 whitespace-pre-line text-sm text-gray-600 dark:text-gray-400">
                {{ $commission->notes ?: 'No notes recorded.' }}
            </p>
        </x-shopper::card>
    </div>
</x-shopper::container>
