<x-shopper::container class="py-5">
    <x-shopper::heading class="mb-6" title="Vouchers">
        <x-slot name="description">
            Generate and track customer payment vouchers and receipts.
        </x-slot>
        @can('create', \App\Models\Voucher::class)
            <x-slot name="action">
                <x-shopper::buttons.primary :link="route('shopper.vouchers.create')">
                    Generate Voucher
                </x-shopper::buttons.primary>
            </x-slot>
        @endcan
    </x-shopper::heading>

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
