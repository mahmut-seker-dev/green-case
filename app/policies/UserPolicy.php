<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function manageUsers(User $user)
    {
        return $user->role === 'admin'; // sadece admin izinli
    }
     public function update(User $user, User $model)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, User $model)
    {
        return $user->role === 'admin';
    }
}
