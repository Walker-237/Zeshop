<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('browse_reports');
    }

    public function view(User $user, Report $report): bool
    {
        return $user->can('read_reports');
    }

    public function create(User $user): bool
    {
        return $user->can('add_reports');
    }

    public function delete(User $user, Report $report): bool
    {
        return $user->can('delete_reports');
    }
}
