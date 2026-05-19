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
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_for' => 'datetime',
            'assigned_at' => 'datetime',
            'picked_up_at' => 'datetime',
            'delivered_at' => 'datetime',
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
}
