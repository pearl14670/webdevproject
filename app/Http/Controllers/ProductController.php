<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Only show active and in-stock products to regular users
        $query->where('is_active', true)
              ->where('stock', '>', 0);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Price range filter
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popularity':
                $query->withCount('orderItems')
                      ->orderBy('order_items_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->with('category')
                         ->paginate(12)
                         ->withQueryString();

        $categories = Category::active()->parents()->get();
        
        // Get min and max prices for the filter
        $priceRange = Product::where('is_active', true)
                            ->where('stock', '>', 0)
                            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
                            ->first();

        return view('products.index', compact('products', 'categories', 'priceRange'));
    }

    public function show(Product $product)
    {
        // Only show active and in-stock products to regular users
        if (!$product->is_active || $product->stock <= 0) {
            abort(404);
        }

        $product->load(['category', 'reviews' => function ($query) {
            $query->approved()->with('user')->latest();
        }]);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
} 