@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Products</h1>
            <p class="text-muted">Manage your products</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Add Product
        </a>
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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px">Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ Storage::url($product->images[0]) }}" 
                                            alt="{{ $product->name }}" 
                                            class="img-thumbnail" 
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>
                                    @if($product->stock > 0)
                                        <span class="text-success">{{ $product->stock }} in stock</span>
                                    @else
                                        <span class="text-danger">Out of stock</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.products.show', $product) }}" 
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" 
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" 
                                            method="POST" 
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-2 mb-3"></i>
                                        <p class="mb-0">No products found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 