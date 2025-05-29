@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('Categories') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Search & Filters') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.show', $category) }}" method="GET">
                        <!-- Search -->
                        <div class="mb-3">
                            <label for="search" class="form-label">{{ __('Search') }}</label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="{{ __('Search in this category...') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('Price Range') }}</label>
                            <div class="row g-2">
                                <div class="col">
                                    <input type="number" 
                                           class="form-control" 
                                           name="min_price" 
                                           value="{{ request('min_price') }}"
                                           placeholder="Min">
                                </div>
                                <div class="col">
                                    <input type="number" 
                                           class="form-control" 
                                           name="max_price" 
                                           value="{{ request('max_price') }}"
                                           placeholder="Max">
                                </div>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">{{ __('Sort By') }}</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                    {{ __('Newest First') }}
                                </option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                    {{ __('Price: Low to High') }}
                                </option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                    {{ __('Price: High to Low') }}
                                </option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                    {{ __('Name') }}
                                </option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Apply Filters') }}
                            </button>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-secondary">
                                {{ __('Clear Filters') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $category->name }}</h5>
                    <span class="text-muted">{{ $products->total() }} {{ __('products found') }}</span>
                </div>
                <div class="card-body">
                    @if($products->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-search fs-1 text-muted"></i>
                            <p class="mt-3">{{ __('No products found matching your criteria.') }}</p>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-primary">
                                {{ __('Clear Search') }}
                            </a>
                        </div>
                    @else
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($products as $product)
                                <div class="col">
                                    <div class="card h-100">
                                        @if($product->image)
                                            <img src="{{ $product->image }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $product->name }}"
                                                 style="height: 200px; object-fit: cover;">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text text-muted">
                                                {{ Str::limit($product->description, 100) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-5">${{ number_format($product->price, 2) }}</span>
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bi bi-cart-plus"></i> {{ __('Add to Cart') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 