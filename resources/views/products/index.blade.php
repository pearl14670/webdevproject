@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <div class="input-group">
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       class="form-control" 
                                       placeholder="Search products..." 
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="row g-2">
                                <div class="col">
                                    <input type="number" 
                                           name="min_price" 
                                           class="form-control" 
                                           placeholder="Min" 
                                           value="{{ request('min_price', '') }}"
                                           min="0"
                                           step="0.01">
                                </div>
                                <div class="col">
                                    <input type="number" 
                                           name="max_price" 
                                           class="form-control" 
                                           placeholder="Max" 
                                           value="{{ request('max_price', '') }}"
                                           min="0"
                                           step="0.01">
                                </div>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">Sort By</label>
                            <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularity</option>
                            </select>
                        </div>

                        <!-- Clear Filters -->
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                            <div class="d-grid">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Clear Filters
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Products</h2>
                    <p class="text-muted mb-0">{{ $products->total() }} products found</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ Storage::url($product->images[0]) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $product->name }}</h5>
                                <p class="text-muted small mb-2">
                                    <a href="{{ route('categories.show', $product->category) }}" class="text-decoration-none">
                                        {{ $product->category->name }}
                                    </a>
                                </p>
                                <p class="card-text text-truncate">{{ $product->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                                    @auth
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                            <i class="bi bi-box-arrow-in-right"></i> Login to Buy
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-search display-1 text-muted mb-3"></i>
                            <h3>No Products Found</h3>
                            <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Enhanced Pagination Styles */
    .pagination {
        justify-content: center;
        gap: 0;
        margin-top: 2rem;
        flex-wrap: wrap;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        display: inline-flex;
        border-radius: 4px;
    }

    .page-item .page-link,
    [aria-label^="Go to page"] {
        border-radius: 0;
        padding: 0.4rem !important;
        font-size: 0.875rem;
        border: 1px solid #dee2e6;
        margin: 0;
        min-width: 32px !important;
        height: 32px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #495057;
        transition: all 0.2s ease;
        background-color: white;
        position: relative;
        font-weight: 500;
    }

    /* Hide SVG arrows and show text instead */
    .page-item:first-child .page-link svg,
    .page-item:last-child .page-link svg,
    [aria-label$="Previous"] svg,
    [aria-label$="Next"] svg,
    [aria-disabled="true"] svg {
        display: none !important;
    }

    .page-item:first-child .page-link::before,
    [aria-label$="Previous"]::before {
        content: "Prev" !important;
        font-size: 0.875rem;
    }

    .page-item:last-child .page-link::before,
    [aria-label$="Next"]::before {
        content: "Next" !important;
        font-size: 0.875rem;
    }

    /* Make Previous/Next text buttons same size as numbers */
    .page-item:first-child .page-link,
    .page-item:last-child .page-link,
    [aria-label$="Previous"],
    [aria-label$="Next"],
    [aria-disabled="true"] {
        min-width: 50px !important;
        width: auto !important;
        height: 32px !important;
        padding: 0.4rem 0.75rem !important;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-item:first-child .page-link,
    [aria-label$="Previous"] {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .page-item:last-child .page-link,
    [aria-label$="Next"],
    [aria-disabled="true"] {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .page-item.active .page-link,
    [aria-current="page"] span {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
        font-weight: 600;
        z-index: 3;
    }

    .page-item:not(.active):not(.disabled) .page-link:hover,
    [aria-label^="Go to page"]:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #0d6efd;
        z-index: 2;
    }

    .page-item.disabled .page-link,
    [aria-disabled="true"] {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #adb5bd;
        cursor: not-allowed;
    }

    /* Remove margin between pagination items */
    .page-item:not(:first-child) .page-link,
    [aria-label^="Go to page"],
    [aria-current="page"] span,
    [aria-disabled="true"] {
        margin-left: -1px;
    }

    /* Center pagination container */
    .pagination-container,
    .relative.z-0.inline-flex.rtl\\:flex-row-reverse.shadow-sm.rounded-md {
        display: flex;
        justify-content: center;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .page-item .page-link,
        [aria-label^="Go to page"],
        [aria-current="page"] span {
            min-width: 30px !important;
            height: 30px !important;
            padding: 0.375rem !important;
            font-size: 0.8125rem;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link,
        [aria-label$="Previous"],
        [aria-label$="Next"],
        [aria-disabled="true"] {
            min-width: 45px !important;
            padding: 0.375rem 0.5rem !important;
            height: 30px !important;
        }

        .page-item:first-child .page-link::before,
        [aria-label$="Previous"]::before,
        .page-item:last-child .page-link::before,
        [aria-label$="Next"]::before {
            font-size: 0.8125rem;
        }
    }

    @media (max-width: 576px) {
        .page-item .page-link,
        [aria-label^="Go to page"],
        [aria-current="page"] span {
            min-width: 28px !important;
            height: 28px !important;
            padding: 0.35rem !important;
            font-size: 0.75rem;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link,
        [aria-label$="Previous"],
        [aria-label$="Next"],
        [aria-disabled="true"] {
            min-width: 40px !important;
            padding: 0.35rem 0.5rem !important;
            height: 28px !important;
        }

        .page-item:first-child .page-link::before,
        [aria-label$="Previous"]::before,
        .page-item:last-child .page-link::before,
        [aria-label$="Next"]::before {
            font-size: 0.75rem;
        }
    }
</style>
@endsection