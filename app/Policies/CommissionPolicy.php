<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Commission;
use App\Models\User;

class CommissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('browse_commissions');
    }

    public function view(User $user, Commission $commission): bool
    {
        return $user->can('read_commissions')
            && (! $user->hasRole('seller') || $commission->seller_id === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->can('add_commissions');
    }

    public function update(User $user, Commission $commission): bool
    {
        return $user->can('edit_commissions');
    }

    public function delete(User $user, Commission $commission): bool
    {
        return $user->can('delete_commissions');
    }
}
