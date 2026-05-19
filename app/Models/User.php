<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Shopper\Core\Models\User as ShopperUser;

class User extends ShopperUser
{
    public function isAdmin(): bool
    {
        return $this->hasRole(config('shopper.core.users.admin_role'));
    }

    public function scopeAdministrators(Builder $query): Builder
    {
        return $query->whereHas('roles', function (Builder $query): void {
            $query->whereIn('name', [
                config('shopper.core.users.admin_role'),
                config('shopper.core.users.manager_role'),
                'accountant',
                'stock_manager',
                'delivery_person',
                'seller',
            ]);
        });
    }
}
