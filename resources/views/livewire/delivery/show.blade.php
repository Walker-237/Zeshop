<x-shopper::container class="py-5">
    <x-shopper::breadcrumb
        :back="route('shopper.deliveries.index')"
        current="Delivery Details"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.deliveries.index')"
            title="Deliveries"
        />
    </x-shopper::breadcrumb>

    <div class="my-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <x-shopper::heading class="mb-0" title="Delivery Details">
            <x-slot name="description">
                {{ $delivery->tracking_number ?? 'No tracking number' }} - {{ $delivery->order?->number ?? 'No order' }}
            </x-slot>
        </x-shopper::heading>

        <div class="flex flex-wrap items-center gap-3">
            @can('update', $delivery)
                <x-shopper::buttons.default :link="route('shopper.deliveries.edit', $delivery)">
                    Edit
                </x-shopper::buttons.default>
                @if (in_array($delivery->status, ['pending', 'assigned'], true))
                    <x-shopper::buttons.primary wire:click="markPickedUp">
                        Picked Up
                    </x-shopper::buttons.primary>
                @endif
                @if ($delivery->status === 'picked_up')
                    <x-shopper::buttons.primary wire:click="markInTransit">
                        In Transit
                    </x-shopper::buttons.primary>
                @endif
                @if (! in_array($delivery->status, ['delivered', 'cancelled'], true))
                    <x-shopper::buttons.primary wire:click="markDelivered">
                        Delivered
                    </x-shopper::buttons.primary>
                @endif
                @if ($delivery->status !== 'cancelled')
                    <x-shopper::buttons.default wire:click="cancel">
                        Cancel Delivery
                    </x-shopper::buttons.default>
                @endif
            @endcan
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <x-shopper::card class="p-6 lg:col-span-2">
            <dl class="grid gap-5 text-sm sm:grid-cols-2">
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Order</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->order?->number ?? 'No order' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Delivery Person</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->deliveryPerson?->full_name ?? 'Unassigned' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Tracking Number</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->tracking_number ?? 'Not set' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Status</dt>
                    <dd class="mt-1 capitalize text-gray-600 dark:text-gray-400">{{ str_replace('_', ' ', $delivery->status) }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Scheduled For</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->scheduled_for?->format('M j, Y g:i A') ?? 'Not scheduled' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Assigned At</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->assigned_at?->format('M j, Y g:i A') ?? 'Not assigned' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Picked Up At</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->picked_up_at?->format('M j, Y g:i A') ?? 'Not picked up' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Delivered At</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->delivered_at?->format('M j, Y g:i A') ?? 'Not delivered' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Delivered To</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->delivered_to ?? 'Not specified' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-900 dark:text-white">Destination</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ $delivery->order?->shippingAddress?->city ?? 'No address' }}</dd>
                </div>
            </dl>
        </x-shopper::card>

        <x-shopper::card class="p-6">
            <h2 class="font-medium text-gray-900 dark:text-white">Notes</h2>
            <p class="mt-3 whitespace-pre-line text-sm text-gray-600 dark:text-gray-400">
                {{ $delivery->notes ?: 'No notes recorded.' }}
            </p>

            @if ($delivery->failure_reason)
                <h2 class="mt-6 font-medium text-gray-900 dark:text-white">Failure Reason</h2>
                <p class="mt-3 whitespace-pre-line text-sm text-gray-600 dark:text-gray-400">
                    {{ $delivery->failure_reason }}
                </p>
            @endif
        </x-shopper::card>
    </div>
</x-shopper::container>
