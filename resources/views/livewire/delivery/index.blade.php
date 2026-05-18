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

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
