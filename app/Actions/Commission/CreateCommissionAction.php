<?php

declare(strict_types=1);

namespace App\Actions\Commission;

use App\Models\Commission;
use App\Models\User;
use Shopper\Core\Models\Order;

final class CreateCommissionAction
{
    public function execute(Order $order, ?User $seller = null, float $rate = 10.0, ?float $amount = null, ?string $notes = null): Commission
    {
        $amount ??= round(($order->total() / 100) * ($rate / 100), 2);

        return Commission::query()->updateOrCreate([
            'seller_id' => $seller?->id,
            'order_id' => $order->id,
        ], [
            'amount' => $amount,
            'rate' => $rate,
            'status' => 'pending',
            'notes' => $notes,
        ]);
    }
}
