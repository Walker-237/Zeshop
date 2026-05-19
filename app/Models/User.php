<?php

namespace App\Models;

use Shopper\Core\Models\User as ShopperUser;

class User extends ShopperUser
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'birth_date',
        'gender',
        'email_verified_at',
    ];
}