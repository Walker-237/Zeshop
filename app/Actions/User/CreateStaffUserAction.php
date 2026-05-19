<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Shopper\Core\Models\Role;

final class CreateStaffUserAction
{
    public function execute(array $data): User
    {
        /** @var Role $role */
        $role = Role::query()->findOrFail($data['role_id']);

        /** @var User $user */
        $user = User::query()->create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($role->name);

        return $user;
    }
}
