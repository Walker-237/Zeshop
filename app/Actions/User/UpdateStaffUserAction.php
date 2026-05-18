<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Shopper\Core\Models\Role;

final class UpdateStaffUserAction
{
    public function execute(User $user, array $data): User
    {
        /** @var Role $role */
        $role = Role::query()->findOrFail($data['role_id']);

        $user->update([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'password' => filled($data['password'] ?? null)
                ? Hash::make($data['password'])
                : $user->password,
        ]);

        $user->syncRoles([$role->name]);

        return $user;
    }
}
