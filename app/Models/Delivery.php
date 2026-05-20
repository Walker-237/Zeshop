<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shopper\Core\Models\Order;

class Delivery extends Model
{
    protected $fillable = [
        'order_id',
        'delivery_person_id',
        'tracking_number',
        'status',
        'scheduled_for',
        'assigned_at',
        'picked_up_at',
        'delivered_at',
        'failed_at',
        'cancelled_at',
        'delivered_to',
        'failure_reason',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_for' => 'datetime',
            'assigned_at' => 'datetime',
            'picked_up_at' => 'datetime',
            'delivered_at' => 'datetime',
            'failed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function deliveryPerson(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delivery_person_id');
    }

    public function markPickedUp(?string $notes = null): bool
    {
        return $this->update([
            'status' => 'picked_up',
            'picked_up_at' => $this->picked_up_at ?? now(),
            'notes' => $notes ?? $this->notes,
        ]);
    }

    public function markInTransit(?string $notes = null): bool
    {
        return $this->update([
            'status' => 'in_transit',
            'notes' => $notes ?? $this->notes,
        ]);
    }

    public function markDelivered(?string $deliveredTo = null, ?string $notes = null): bool
    {
        return $this->update([
            'status' => 'delivered',
            'delivered_at' => $this->delivered_at ?? now(),
            'delivered_to' => $deliveredTo ?? $this->delivered_to,
            'failure_reason' => null,
            'notes' => $notes ?? $this->notes,
        ]);
    }

    public function markFailed(?string $failureReason = null, ?string $notes = null): bool
    {
        return $this->update([
            'status' => 'failed',
            'failed_at' => $this->failed_at ?? now(),
            'failure_reason' => $failureReason ?? $this->failure_reason,
            'notes' => $notes ?? $this->notes,
        ]);
    }

    public function cancel(?string $notes = null): bool
    {
        return $this->update([
            'status' => 'cancelled',
            'cancelled_at' => $this->cancelled_at ?? now(),
            'notes' => $notes ?? $this->notes,
        ]);
    }
}
