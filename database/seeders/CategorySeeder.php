<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Backpacks',
                'description' => 'Versatile bags for everyday use, travel, and outdoor activities',
                'is_active' => true,
            ],
            [
                'name' => 'Handbags',
                'description' => 'Stylish bags for a sophisticated look',
                'is_active' => true,
            ],
            [
                'name' => 'Shoulder Bags',
                'description' => 'Comfortable and practical bags for daily use',
                'is_active' => true,
            ],
            [
                'name' => 'Tote Bags',
                'description' => 'Spacious bags perfect for shopping and casual use',
                'is_active' => true,
            ],
            [
                'name' => 'Crossbody Bags',
                'description' => 'Hands-free bags for convenience and style',
                'is_active' => true,
            ],
            [
                'name' => 'Travel Bags',
                'description' => 'Durable bags designed for travel and adventure',
                'is_active' => true,
            ],
            [
                'name' => 'Laptop Bags',
                'description' => 'Protective bags specifically designed for laptops and electronics',
                'is_active' => true,
            ],
            [
                'name' => 'Mini Bags',
                'description' => 'Compact bags for essentials and evening occasions',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }
    }
} 