<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $products = Product::take(3)->get();

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'total_amount' => 0,
            'shipping_cost' => 5.00,
            'status' => Order::STATUS_PENDING,
            'shipping_address' => [
                'name' => 'John Doe',
                'address' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country' => 'USA',
                'phone' => '1234567890'
            ],
            'billing_address' => [
                'name' => 'John Doe',
                'address' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country' => 'USA',
                'phone' => '1234567890'
            ],
            'payment_method' => 'credit_card',
            'payment_status' => Order::PAYMENT_STATUS_PAID,
            'shipping_method' => 'standard',
            'notes' => 'Test order'
        ]);

        $total = 0;
        foreach ($products as $product) {
            $quantity = rand(1, 3);
            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ]);
        }

        $order->update([
            'total_amount' => $total + $order->shipping_cost
        ]);
    }
}
