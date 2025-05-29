@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ __('Shopping Cart') }}</h2>
                    <span class="badge bg-primary">{{ $cart->items_count }} {{ __('items') }}</span>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($cart->items->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-cart-x fs-1 text-muted"></i>
                            <p class="mt-3">{{ __('Your cart is empty.') }}</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                {{ __('Continue Shopping') }}
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>{{ __('Product') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th class="text-end">{{ __('Total') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ $item->product->image }}" 
                                                             alt="{{ $item->product->name }}"
                                                             class="me-3"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                        @if($item->product->sku)
                                                            <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ $item->formatted_price }}</td>
                                            <td style="width: 200px;">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" 
                                                           name="quantity" 
                                                           value="{{ $item->quantity }}" 
                                                           min="1"
                                                           class="form-control form-control-sm me-2"
                                                           style="width: 80px;">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        {{ __('Update') }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-end">${{ $item->formatted_total }}</td>
                                            <td>
                                                <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">
                                            <strong>{{ __('Total:') }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <strong>${{ $cart->formatted_total }}</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    {{ __('Clear Cart') }}
                                </button>
                            </form>

                            <div>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-2">
                                    {{ __('Continue Shopping') }}
                                </a>
                                <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                                    {{ __('Proceed to Checkout') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 