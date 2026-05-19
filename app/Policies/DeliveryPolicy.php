<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Delivery;
use App\Models\User;

class DeliveryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('browse_deliveries');
    }

    public function view(User $user, Delivery $delivery): bool
    {
        return $user->can('read_deliveries')
            && (! $user->hasRole('delivery_person') || $delivery->delivery_person_id === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->can('add_deliveries');
    }

    public function update(User $user, Delivery $delivery): bool
    {
        return $user->can('edit_deliveries')
            && (! $user->hasRole('delivery_person') || $delivery->delivery_person_id === $user->id);
    }

    public function delete(User $user, Delivery $delivery): bool
    {
        return $user->can('delete_deliveries');
    }
}
