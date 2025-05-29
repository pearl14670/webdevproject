<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($order->load('items.product'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|array',
            'shipping_address.name' => 'required|string',
            'shipping_address.address' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.state' => 'required|string',
            'shipping_address.postal_code' => 'required|string',
            'shipping_address.country' => 'required|string',
            'shipping_address.phone' => 'required|string',
            'billing_address' => 'required|array',
            'billing_address.name' => 'required|string',
            'billing_address.address' => 'required|string',
            'billing_address.city' => 'required|string',
            'billing_address.state' => 'required|string',
            'billing_address.postal_code' => 'required|string',
            'billing_address.country' => 'required|string',
            'billing_address.phone' => 'required|string',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty'
            ], 422);
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => "Insufficient stock for product: {$item->product->name}"
                ], 422);
            }
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'total_amount' => $cartItems->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                }),
                'shipping_cost' => 0, // Calculate based on shipping method
                'shipping_address' => $validated['shipping_address'],
                'billing_address' => $validated['billing_address'],
                'payment_method' => $validated['payment_method'],
                'shipping_method' => $validated['shipping_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            auth()->user()->cartItems()->delete();

            DB::commit();

            // TODO: Send order confirmation email

            return response()->json([
                'message' => 'Order placed successfully',
                'order' => $order->load('items.product')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', [
                Order::STATUS_PENDING,
                Order::STATUS_PROCESSING,
                Order::STATUS_SHIPPED,
                Order::STATUS_DELIVERED,
                Order::STATUS_CANCELLED
            ])
        ]);

        $order->update($validated);

        // TODO: Send order status update notification

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order->load('items.product')
        ]);
    }

    private function generateOrderNumber()
    {
        do {
            $number = strtoupper(date('Ymd') . Str::random(4));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
} 