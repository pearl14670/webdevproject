@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1">{{ $category->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">{{ $category->name }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit Category
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}"
                             class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3" 
                             style="height: 200px;">
                            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                        </div>
                    @endif

                    <dl class="mb-0">
                        <dt>Description</dt>
                        <dd class="text-muted">
                            {{ $category->description ?: 'No description available' }}
                        </dd>

                        <dt class="mt-3">Parent Category</dt>
                        <dd>
                            @if($category->parent)
                                <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-decoration-none">
                                    {{ $category->parent->name }}
                                </a>
                            @else
                                <span class="text-muted">None (Top Level Category)</span>
                            @endif
                        </dd>

                        <dt class="mt-3">Created</dt>
                        <dd>{{ $category->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="mt-3">Last Updated</dt>
                        <dd>{{ $category->updated_at->format('M d, Y H:i') }}</dd>

                        <dt class="mt-3">Slug</dt>
                        <dd class="text-muted">{{ $category->slug }}</dd>
                    </dl>
                </div>
            </div>

            @if($category->children->isNotEmpty())
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Subcategories</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($category->children as $child)
                                <a href="{{ route('admin.categories.show', $child) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    {{ $child->name }}
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $child->products_count ?? 0 }} products
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Products</h5>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-lg"></i> Add Product
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($category->products->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products as $product)
                                        <tr>
                                            <td style="width: 80px;">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" 
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
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                @if($product->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.show', $product) }}" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-box-seam text-muted mb-2" style="font-size: 2rem;"></i>
                            <h6 class="text-muted mb-2">No products in this category</h6>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                                Add your first product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 