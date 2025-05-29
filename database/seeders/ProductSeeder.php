<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Backpacks
            [
                'name' => 'Urban Explorer Backpack',
                'description' => 'A versatile backpack perfect for daily commute and weekend adventures. Features multiple compartments, laptop sleeve, and water-resistant material.',
                'price' => 79.99,
                'stock' => 50,
                'category_name' => 'Backpacks',
                'is_active' => true,
            ],
            [
                'name' => 'Student Essential Backpack',
                'description' => 'Designed for students with dedicated laptop compartment, tablet sleeve, and plenty of organization for books and supplies.',
                'price' => 49.99,
                'stock' => 75,
                'category_name' => 'Backpacks',
                'is_active' => true,
            ],
            [
                'name' => 'Adventure Pro Hiking Backpack',
                'description' => 'Rugged hiking backpack with 45L capacity, hydration system compatibility, and ergonomic design for long treks.',
                'price' => 129.99,
                'stock' => 30,
                'category_name' => 'Backpacks',
                'is_active' => true,
            ],
            [
                'name' => 'Minimalist Travel Backpack',
                'description' => 'Sleek and compact backpack perfect for minimalist travelers. Features anti-theft design and USB charging port.',
                'price' => 89.99,
                'stock' => 40,
                'category_name' => 'Backpacks',
                'is_active' => true,
            ],
            
            // Handbags
            [
                'name' => 'Classic Leather Handbag',
                'description' => 'Timeless leather handbag with elegant design. Perfect for both casual and formal occasions.',
                'price' => 129.99,
                'stock' => 30,
                'category_name' => 'Handbags',
                'is_active' => true,
            ],
            [
                'name' => 'Modern Structured Handbag',
                'description' => 'Contemporary structured handbag with clean lines and premium hardware. Includes removable shoulder strap.',
                'price' => 89.99,
                'stock' => 40,
                'category_name' => 'Handbags',
                'is_active' => true,
            ],
            [
                'name' => 'Luxury Chain Strap Handbag',
                'description' => 'Designer-inspired handbag with gold chain strap and quilted pattern. Made from premium vegan leather.',
                'price' => 149.99,
                'stock' => 25,
                'category_name' => 'Handbags',
                'is_active' => true,
            ],
            [
                'name' => 'Bohemian Fringe Handbag',
                'description' => 'Boho-chic handbag with decorative fringe and woven details. Perfect for festival season and casual outings.',
                'price' => 79.99,
                'stock' => 35,
                'category_name' => 'Handbags',
                'is_active' => true,
            ],

            // Shoulder Bags
            [
                'name' => 'Casual Hobo Shoulder Bag',
                'description' => 'Soft and spacious hobo bag perfect for everyday use. Features multiple interior pockets.',
                'price' => 69.99,
                'stock' => 45,
                'category_name' => 'Shoulder Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Professional Laptop Shoulder Bag',
                'description' => 'Sleek shoulder bag designed for professionals. Fits up to 15" laptop with dedicated compartments for accessories.',
                'price' => 99.99,
                'stock' => 35,
                'category_name' => 'Shoulder Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Vintage Messenger Shoulder Bag',
                'description' => 'Retro-style messenger bag with distressed leather look. Perfect for carrying books, tablets, and daily essentials.',
                'price' => 84.99,
                'stock' => 30,
                'category_name' => 'Shoulder Bags',
                'is_active' => true,
            ],

            // Tote Bags
            [
                'name' => 'Large Canvas Tote',
                'description' => 'Durable canvas tote with reinforced handles. Perfect for shopping, beach trips, or daily use.',
                'price' => 39.99,
                'stock' => 100,
                'category_name' => 'Tote Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Premium Leather Tote',
                'description' => 'Luxurious leather tote with suede interior. Features laptop sleeve and organizational pockets.',
                'price' => 159.99,
                'stock' => 25,
                'category_name' => 'Tote Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Reversible Beach Tote',
                'description' => 'Two-in-one beach tote with waterproof lining. Includes matching waterproof pouch for valuables.',
                'price' => 49.99,
                'stock' => 60,
                'category_name' => 'Tote Bags',
                'is_active' => true,
            ],

            // Crossbody Bags
            [
                'name' => 'Compact Crossbody Bag',
                'description' => 'Sleek crossbody bag with adjustable strap. Perfect size for essentials with RFID protection.',
                'price' => 59.99,
                'stock' => 60,
                'category_name' => 'Crossbody Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Multi-Pocket Crossbody Organizer',
                'description' => 'Functional crossbody with multiple compartments. Perfect for travel with anti-theft features.',
                'price' => 69.99,
                'stock' => 45,
                'category_name' => 'Crossbody Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion Chain Crossbody',
                'description' => 'Trendy crossbody bag with decorative chain detail. Available in metallic finish.',
                'price' => 54.99,
                'stock' => 50,
                'category_name' => 'Crossbody Bags',
                'is_active' => true,
            ],

            // Travel Bags
            [
                'name' => 'Weekend Duffle Bag',
                'description' => 'Spacious duffle bag with shoe compartment and multiple pockets. Perfect for short trips.',
                'price' => 89.99,
                'stock' => 35,
                'category_name' => 'Travel Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Rolling Travel Suitcase',
                'description' => 'Durable hardshell suitcase with 360° wheels and TSA-approved lock. Available in 22" carry-on size.',
                'price' => 159.99,
                'stock' => 25,
                'category_name' => 'Travel Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Travel Organizer Set',
                'description' => 'Set of 6 packing cubes and toiletry bag. Perfect for organizing luggage during travel.',
                'price' => 44.99,
                'stock' => 50,
                'category_name' => 'Travel Bags',
                'is_active' => true,
            ],

            // Laptop Bags
            [
                'name' => 'Professional Laptop Briefcase',
                'description' => 'Sleek laptop briefcase with padded compartment for up to 15" laptops. Includes organizer pockets.',
                'price' => 79.99,
                'stock' => 40,
                'category_name' => 'Laptop Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Modern Laptop Sleeve',
                'description' => 'Minimalist laptop sleeve with water-resistant exterior. Available for 13", 14", and 15" laptops.',
                'price' => 34.99,
                'stock' => 75,
                'category_name' => 'Laptop Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Tech Organizer Laptop Bag',
                'description' => 'All-in-one laptop bag with dedicated compartments for charger, mouse, and accessories.',
                'price' => 89.99,
                'stock' => 35,
                'category_name' => 'Laptop Bags',
                'is_active' => true,
            ],

            // Mini Bags
            [
                'name' => 'Evening Mini Clutch',
                'description' => 'Elegant mini clutch with detachable chain strap. Perfect for evening events and special occasions.',
                'price' => 49.99,
                'stock' => 50,
                'category_name' => 'Mini Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Mini Backpack Purse',
                'description' => 'Trendy mini backpack in soft faux leather. Perfect size for essentials with convertible straps.',
                'price' => 44.99,
                'stock' => 60,
                'category_name' => 'Mini Bags',
                'is_active' => true,
            ],
            [
                'name' => 'Designer Mini Crossbody',
                'description' => 'Luxury-inspired mini bag with gold hardware. Features card slots and phone compartment.',
                'price' => 59.99,
                'stock' => 40,
                'category_name' => 'Mini Bags',
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category_name'])->first();
            
            if ($category) {
                $product = new Product();
                $product->name = $productData['name'];
                $product->description = $productData['description'];
                $product->price = $productData['price'];
                $product->stock = $productData['stock'];
                $product->category_id = $category->id;
                $product->is_active = $productData['is_active'];
                $product->save();
            }
        }
    }
} 