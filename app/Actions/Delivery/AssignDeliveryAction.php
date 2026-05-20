<?php

declare(strict_types=1);

namespace App\Actions\Delivery;

use App\Models\Delivery;
use App\Models\User;
use Shopper\Core\Models\Order;

final class AssignDeliveryAction
{
    public function execute(
        Order $order,
        ?User $deliveryPerson = null,
        ?string $trackingNumber = null,
        ?string $scheduledFor = null,
        ?string $notes = null,
    ): Delivery {
        return Delivery::query()->updateOrCreate([
            'order_id' => $order->id,
        ], [
            'delivery_person_id' => $deliveryPerson?->id,
            'tracking_number' => $trackingNumber,
            'status' => $deliveryPerson ? 'assigned' : 'pending',
            'scheduled_for' => $scheduledFor,
            'assigned_at' => $deliveryPerson ? now() : null,
            'picked_up_at' => null,
            'delivered_at' => null,
            'failed_at' => null,
            'cancelled_at' => null,
            'delivered_to' => null,
            'failure_reason' => null,
            'notes' => $notes,
        ]);
    }
}
