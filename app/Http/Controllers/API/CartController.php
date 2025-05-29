<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()
            ->with(['product' => function ($query) {
                $query->select('id', 'name', 'price', 'stock', 'images');
            }])
            ->get();

        return response()->json([
            'cart_items' => $cartItems,
            'total' => auth()->user()->cart_total
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->is_active || $product->stock < $validated['quantity']) {
            return response()->json([
                'message' => 'Product is not available in the requested quantity'
            ], 422);
        }

        $cartItem = auth()->user()->cartItems()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->incrementQuantity($validated['quantity']);
        } else {
            $cartItem = auth()->user()->cartItems()->create($validated);
        }

        return response()->json([
            'message' => 'Product added to cart',
            'cart_item' => $cartItem->load('product')
        ]);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorize('update', $cartItem);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cartItem->product->stock < $validated['quantity']) {
            return response()->json([
                'message' => 'Product is not available in the requested quantity'
            ], 422);
        }

        $cartItem->update($validated);

        return response()->json([
            'message' => 'Cart updated',
            'cart_item' => $cartItem->load('product')
        ]);
    }

    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);

        $cartItem->delete();

        return response()->json([
            'message' => 'Product removed from cart'
        ]);
    }

    public function clear()
    {
        auth()->user()->cartItems()->delete();

        return response()->json([
            'message' => 'Cart cleared'
        ]);
    }
} 