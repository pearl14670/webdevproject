<?php

namespace App\Policies\Admin;

use App\Models\Admin;
use App\Models\Product;

class ProductPolicy
{
    public function viewAny(Admin $admin)
    {
        return true;
    }

    public function view(Admin $admin, Product $product)
    {
        return true;
    }

    public function create(Admin $admin)
    {
        return true;
    }

    public function update(Admin $admin, Product $product)
    {
        return true;
    }

    public function delete(Admin $admin, Product $product)
    {
        return true;
    }
} 