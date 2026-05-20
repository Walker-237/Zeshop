<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shopper\Core\Models\Order;

class Commission extends Model
{
    protected $fillable = [
        'seller_id',
        'order_id',
        'amount',
        'rate',
        'status',
        'paid_at',
        'payment_reference',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'rate' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function markPaid(?string $paymentReference = null, ?string $notes = null): bool
    {
        return $this->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_reference' => $paymentReference,
            'notes' => $notes ?? $this->notes,
        ]);
    }

    public function cancel(?string $notes = null): bool
    {
        return $this->update([
            'status' => 'cancelled',
            'notes' => $notes ?? $this->notes,
        ]);
    }
}
