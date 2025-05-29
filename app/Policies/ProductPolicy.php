<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function create(User $user): bool
    {
        return false; // Regular users cannot create products
    }

    public function update(User $user, Product $product): bool
    {
        return false; // Regular users cannot update products
    }

    public function delete(User $user, Product $product): bool
    {
        return false; // Regular users cannot delete products
    }

    public function view(User $user, Product $product): bool
    {
        return true; // All authenticated users can view products
    }
} 