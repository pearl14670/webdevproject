@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Create Product</h1>
                    <p class="text-muted">Add a new product to your store</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Products
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
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
                                required>{{ old('description') }}</textarea>
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
                                            value="{{ old('price') }}" 
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
                                        value="{{ old('stock', 0) }}" 
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
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
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

                        <div class="mb-3">
                            <label for="images" class="form-label">Product Images</label>
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
                                    {{ old('is_active', true) ? 'checked' : '' }}>
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
                                <i class="bi bi-check-lg me-2"></i>Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 