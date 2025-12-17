<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Part;

class PartPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Part $part): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Part $part): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Part $part): bool
    {
        return $user->isAdmin();
    }
}
