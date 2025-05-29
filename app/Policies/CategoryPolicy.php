<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function create(User $user): bool
    {
        return false; // Regular users cannot create categories
    }

    public function update(User $user, Category $category): bool
    {
        return false; // Regular users cannot update categories
    }

    public function delete(User $user, Category $category): bool
    {
        return false; // Regular users cannot delete categories
    }

    public function view(User $user, Category $category): bool
    {
        return true; // All authenticated users can view categories
    }
} 