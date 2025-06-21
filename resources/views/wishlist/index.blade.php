@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">My Wishlist</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($wishlistItems && $wishlistItems->isNotEmpty())
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @foreach($wishlistItems as $product)
                        <div class="col">
                            <div class="card h-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                @else
                                    <div class="card-img-top bg-light text-center py-4">
                                        <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                                    <p class="card-text"><strong>${{ number_format($product->price, 2) }}</strong></p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between">
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                        <form action="{{ route('wishlist.remove', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-heart-fill"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h4>Your wishlist is empty</h4>
                    <p class="text-muted">Browse our products and add items to your wishlist!</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 