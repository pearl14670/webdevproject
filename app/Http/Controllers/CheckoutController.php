<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->activeCart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $user = auth()->user();
        
        // Pre-fill both shipping and billing address
        $shippingAddress = [
            'name' => $user->name,
            'address' => $user->default_address ?? '123 Main Street',
            'city' => $user->default_city ?? 'Cebu City',
            'state' => $user->default_state ?? 'Cebu',
            'postal_code' => $user->default_postal_code ?? '6000',
            'country' => $user->default_country ?? 'PH',
            'phone' => $user->default_phone ?? '+63 123 456 7890'
        ];

        $billingAddress = $shippingAddress;

        return view('checkout.index', compact('cart', 'shippingAddress', 'billingAddress'));
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
            'shipping_address.country' => 'required|string|size:2',
            'shipping_address.phone' => ['required', 'string', 'regex:/^\+?[0-9\s-]{10,}$/'],
            'billing_address' => 'required|array',
            'billing_address.name' => 'required|string',
            'billing_address.address' => 'required|string',
            'billing_address.city' => 'required|string',
            'billing_address.state' => 'required|string',
            'billing_address.postal_code' => 'required|string',
            'billing_address.country' => 'required|string|size:2',
            'billing_address.phone' => ['required', 'string', 'regex:/^\+?[0-9\s-]{10,}$/'],
            'payment_method' => 'required|string|in:credit_card,paypal',
            'shipping_method' => 'required|string|in:standard,express',
            'notes' => 'nullable|string|max:500'
        ]);

        $cart = auth()->user()->activeCart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Check stock availability
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->back()->with('error', "Insufficient stock for product: {$item->product->name}");
            }
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = $cart->total;
            $shippingCost = $this->calculateShippingCost($validated['shipping_method']);
            $total = $subtotal + $shippingCost;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'total_amount' => $total,
                'shipping_cost' => $shippingCost,
                'shipping_address' => $validated['shipping_address'],
                'billing_address' => $validated['billing_address'],
                'payment_method' => $validated['payment_method'],
                'shipping_method' => $validated['shipping_method'],
                'notes' => $validated['notes'] ?? null,
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_STATUS_PENDING
            ]);

            // Create order items and update stock
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                           ->with('success', 'Order placed successfully! Order number: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    private function generateOrderNumber()
    {
        do {
            $number = strtoupper(date('Ymd') . Str::random(4));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    private function calculateShippingCost($shippingMethod)
    {
        return match($shippingMethod) {
            'express' => 15.00,
            default => 5.00, // standard shipping
        };
    }
} 