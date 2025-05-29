@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Edit Product</h1>
                    <p class="text-muted">Update product information</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye me-2"></i>View Product
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

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $product->name) }}" 
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="3" 
                                required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                            class="form-control @error('price') is-invalid @enderror" 
                                            id="price" 
                                            name="price" 
                                            value="{{ old('price', $product->price) }}" 
                                            step="0.01" 
                                            min="0" 
                                            required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input type="number" 
                                        class="form-control @error('stock') is-invalid @enderror" 
                                        id="stock" 
                                        name="stock" 
                                        value="{{ old('stock', $product->stock) }}" 
                                        min="0" 
                                        required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" 
                                        name="category_id" 
                                        required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($product->images && count($product->images) > 0)
                            <div class="mb-3">
                                <label class="form-label">Current Images</label>
                                <div class="row g-3">
                                    @foreach($product->images as $index => $image)
                                        <div class="col-md-3">
                                            <div class="position-relative">
                                                <img src="{{ Storage::url($image) }}" 
                                                    alt="Product image {{ $index + 1 }}" 
                                                    class="img-thumbnail w-100" 
                                                    style="height: 150px; object-fit: cover;">
                                                <div class="form-check position-absolute top-0 end-0 m-2">
                                                    <input type="checkbox" 
                                                        class="form-check-input" 
                                                        id="remove_image_{{ $index }}" 
                                                        name="remove_images[]" 
                                                        value="{{ $image }}">
                                                    <label class="form-check-label visually-hidden" for="remove_image_{{ $index }}">
                                                        Remove image {{ $index + 1 }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-text">Check the boxes to remove images.</div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="images" class="form-label">Add New Images</label>
                            <input type="file" 
                                class="form-control @error('images.*') is-invalid @enderror" 
                                id="images" 
                                name="images[]" 
                                accept="image/*" 
                                multiple>
                            <div class="form-text">You can select multiple images. Maximum size: 2MB per image.</div>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" 
                                    class="form-check-input @error('is_active') is-invalid @enderror" 
                                    id="is_active" 
                                    name="is_active" 
                                    value="1" 
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (Product will be visible in the store)
                                </label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 