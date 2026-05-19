<?php

declare(strict_types=1);

namespace App\Actions\Voucher;

use App\Models\User;
use App\Models\Voucher;
use Shopper\Core\Models\Order;

final class GenerateVoucherAction
{
    public function execute(
        ?Order $order,
        ?User $customer,
        ?User $issuedBy,
        ?float $amount = null,
        ?string $currencyCode = null,
        ?string $paymentMethod = null,
        string $status = 'issued',
        ?string $notes = null,
    ): Voucher {
        $order?->loadMissing('items');

        $amount ??= $order ? round($order->total() / 100, 2) : 0.00;
        $currencyCode ??= $order?->currency_code ?? 'USD';
        $customer ??= $order?->customer;

        return Voucher::query()->create([
            'number' => $this->nextNumber(),
            'order_id' => $order?->id,
            'customer_id' => $customer?->id,
            'issued_by' => $issuedBy?->id,
            'amount' => $amount,
            'currency_code' => strtoupper($currencyCode),
            'payment_method' => $paymentMethod,
            'status' => $status,
            'issued_at' => now(),
            'paid_at' => $status === 'paid' ? now() : null,
            'notes' => $notes,
        ]);
    }

    private function nextNumber(): string
    {
        $prefix = 'VCH-' . now()->format('Ymd') . '-';
        $latest = Voucher::query()
            ->where('number', 'like', $prefix . '%')
            ->latest('id')
            ->value('number');

        $next = $latest ? ((int) str($latest)->afterLast('-')->toString()) + 1 : 1;

        return $prefix . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }
}
