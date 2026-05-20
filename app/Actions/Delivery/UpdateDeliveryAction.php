<?php

declare(strict_types=1);

namespace App\Actions\Delivery;

use App\Models\Delivery;
use App\Models\User;
use Shopper\Core\Models\Order;

final class UpdateDeliveryAction
{
    public function execute(
        Delivery $delivery,
        Order $order,
        ?User $deliveryPerson,
        ?string $trackingNumber,
        string $status,
        ?string $scheduledFor,
        ?string $deliveredTo,
        ?string $failureReason,
        ?string $notes,
    ): Delivery {
        $delivery->update([
            'order_id' => $order->id,
            'delivery_person_id' => $deliveryPerson?->id,
            'tracking_number' => $trackingNumber,
            'status' => $status,
            'scheduled_for' => $scheduledFor,
            'assigned_at' => $deliveryPerson ? ($delivery->assigned_at ?? now()) : null,
            'picked_up_at' => in_array($status, ['picked_up', 'in_transit', 'delivered'], true)
                ? ($delivery->picked_up_at ?? now())
                : null,
            'delivered_at' => $status === 'delivered'
                ? ($delivery->delivered_at ?? now())
                : null,
            'failed_at' => $status === 'failed'
                ? ($delivery->failed_at ?? now())
                : null,
            'cancelled_at' => $status === 'cancelled'
                ? ($delivery->cancelled_at ?? now())
                : null,
            'delivered_to' => $status === 'delivered' ? $deliveredTo : null,
            'failure_reason' => $status === 'failed' ? $failureReason : null,
            'notes' => $notes,
        ]);

        return $delivery->refresh();
    }
}
