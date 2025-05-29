<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlist()
            ->with('product')
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Product $product)
    {
        $wishlistItem = auth()->user()->wishlist()
            ->firstOrCreate(['product_id' => $product->id]);

        return back()->with('success', 'Product added to wishlist successfully.');
    }

    public function destroy(Product $product)
    {
        auth()->user()->wishlist()
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Product removed from wishlist successfully.');
    }
} 