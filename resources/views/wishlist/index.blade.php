@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ __('My Wishlist') }}</h2>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($wishlistItems->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-heart fs-1 text-muted"></i>
                            <p class="mt-3">{{ __('Your wishlist is empty.') }}</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                {{ __('Browse Products') }}
                            </a>
                        </div>
                    @else
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($wishlistItems as $item)
                                <div class="col">
                                    <div class="card h-100">
                                        @if($item->product->image)
                                            <img src="{{ $item->product->image }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $item->product->name }}"
                                                 style="height: 200px; object-fit: cover;">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->product->name }}</h5>
                                            <p class="card-text text-muted">
                                                {{ Str::limit($item->product->description, 100) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-5">${{ number_format($item->product->price, 2) }}</span>
                                                <div class="btn-group">
                                                    <form action="{{ route('cart.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="btn btn-primary me-2">
                                                            <i class="bi bi-cart-plus"></i> {{ __('Add to Cart') }}
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('wishlist.destroy', $item->product) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $wishlistItems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 