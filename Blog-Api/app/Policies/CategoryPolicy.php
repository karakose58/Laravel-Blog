<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }
    
    public function update(User $user, Category $category): bool
    {
        return $user->hasRole('admin');
    }
    
    public function delete(User $user, Category $category): bool
    {
        return $user->hasRole('admin');
    }
    
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return false;
    }
}
