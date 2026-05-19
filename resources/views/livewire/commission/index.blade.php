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

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
