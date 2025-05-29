<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::parents()
            ->with('children')
            ->withCount('products')
            ->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Request $request, Category $category)
    {
        $query = $category->products();

        // If there's a search query
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        // Add price filter if present
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Add sorting
        $sort = $request->sort ?? 'newest';
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
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        return view('categories.show', compact('category', 'products'));
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        $categories = Category::all(); // For parent selection
        return view('categories.create', compact('categories'));
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        $categories = Category::where('id', '!=', $category->id)->get(); // For parent selection
        return view('categories.edit', compact('category', 'categories'));
    }
} 