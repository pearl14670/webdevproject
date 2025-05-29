@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">{{ $product->name }}</h1>
                    <p class="text-muted mb-0">Product Details</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Product
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($product->images && count($product->images) > 0)
                                <div id="productImages" class="carousel slide mb-4" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($product->images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url($image) }}" 
                                                    class="d-block w-100 rounded" 
                                                    alt="{{ $product->name }}"
                                                    style="height: 300px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($product->images) > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#productImages" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#productImages" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded mb-4" style="height: 300px;">
                                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="border-0" style="width: 150px;">Name</th>
                                        <td class="border-0">{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-0">Description</th>
                                        <td class="border-0">{{ $product->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $product->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stock</th>
                                        <td>
                                            @if($product->stock > 0)
                                                <span class="text-success">{{ $product->stock }} in stock</span>
                                            @else
                                                <span class="text-danger">Out of stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($product->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created</th>
                                        <td>{{ $product->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td>{{ $product->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="h5 mb-3">Description</h4>
                        <div class="bg-light rounded p-3">
                            {{ $product->description }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.destroy', $product) }}" 
                        method="POST" 
                        class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 