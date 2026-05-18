<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Voucher;

class VoucherPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('browse_vouchers');
    }

    public function view(User $user, Voucher $voucher): bool
    {
        return $user->can('read_vouchers');
    }

    public function create(User $user): bool
    {
        return $user->can('add_vouchers');
    }

    public function update(User $user, Voucher $voucher): bool
    {
        return $user->can('edit_vouchers');
    }

    public function delete(User $user, Voucher $voucher): bool
    {
        return $user->can('delete_vouchers');
    }
}
