<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = auth()->user()->wishlist()
            ->with(['category'])
            ->get();

        return response()->json([
            'wishlist' => $wishlist
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->is_active) {
            return response()->json([
                'message' => 'Product is not available'
            ], 422);
        }

        if (auth()->user()->hasProductInWishlist($product)) {
            return response()->json([
                'message' => 'Product is already in wishlist'
            ], 422);
        }

        auth()->user()->wishlist()->attach($product->id);

        return response()->json([
            'message' => 'Product added to wishlist',
            'product' => $product->load('category')
        ]);
    }

    public function destroy(Product $product)
    {
        auth()->user()->wishlist()->detach($product->id);

        return response()->json([
            'message' => 'Product removed from wishlist'
        ]);
    }

    public function clear()
    {
        auth()->user()->wishlist()->detach();

        return response()->json([
            'message' => 'Wishlist cleared'
        ]);
    }

    public function moveToCart(Product $product)
    {
        if (!$product->is_active || $product->stock <= 0) {
            return response()->json([
                'message' => 'Product is not available'
            ], 422);
        }

        auth()->user()->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        auth()->user()->wishlist()->detach($product->id);

        return response()->json([
            'message' => 'Product moved to cart'
        ]);
    }
} 