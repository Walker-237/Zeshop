<?php

declare(strict_types=1);

namespace App\Actions\Commission;

use App\Models\Commission;
use App\Models\User;
use Shopper\Core\Models\Order;

final class UpdateCommissionAction
{
    public function execute(
        Commission $commission,
        Order $order,
        ?User $seller,
        float $rate,
        ?float $amount,
        string $status,
        ?string $paymentReference,
        ?string $notes,
    ): Commission {
        $amount ??= round(($order->total() / 100) * ($rate / 100), 2);

        $commission->update([
            'seller_id' => $seller?->id,
            'order_id' => $order->id,
            'amount' => $amount,
            'rate' => $rate,
            'status' => $status,
            'paid_at' => $status === 'paid'
                ? ($commission->paid_at ?? now())
                : null,
            'payment_reference' => $status === 'paid' ? $paymentReference : null,
            'notes' => $notes,
        ]);

        return $commission->refresh();
    }
}
