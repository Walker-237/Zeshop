<x-shopper::container class="py-5">
    <x-shopper::breadcrumb
        :back="route('shopper.vouchers.index')"
        current="Voucher"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.vouchers.index')"
            title="Vouchers"
        />
    </x-shopper::breadcrumb>

    <div class="my-6 flex items-start justify-between gap-4">
        <x-shopper::heading class="mb-0" :title="$voucher->number">
            <x-slot name="description">
                {{ $voucher->currency_code }} {{ number_format((float) $voucher->amount, 2) }} issued {{ $voucher->issued_at?->format('M j, Y') }}
            </x-slot>
        </x-shopper::heading>

        @can('update', $voucher)
            @if ($voucher->status !== 'paid')
            <x-shopper::buttons.primary wire:click="markPaid">
                Mark Paid
            </x-shopper::buttons.primary>
            @endif
        @endcan
    </div>

    <x-shopper::card class="p-6">
        <div class="mb-6 grid gap-4 text-sm text-gray-600 dark:text-gray-400 md:grid-cols-3">
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Order</div>
                <div>{{ $voucher->order?->number ?? 'Manual voucher' }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Customer</div>
                <div>{{ $voucher->customer?->full_name ?? 'Walk-in / unknown' }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Status</div>
                <div>{{ ucfirst($voucher->status) }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Amount</div>
                <div>{{ $voucher->currency_code }} {{ number_format((float) $voucher->amount, 2) }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Payment Method</div>
                <div>{{ $voucher->payment_method ?? 'Not specified' }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Issued By</div>
                <div>{{ $voucher->issuedBy?->full_name ?? 'System' }}</div>
            </div>
        </div>

        @if (filled($voucher->notes))
            <div class="whitespace-pre-line text-sm leading-6 text-gray-800 dark:text-gray-200">
                {{ $voucher->notes }}
            </div>
        @endif
    </x-shopper::card>
</x-shopper::container>
