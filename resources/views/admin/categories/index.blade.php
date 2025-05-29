@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Products</th>
                            <th>Parent</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td style="width: 100px;">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" 
                                             alt="{{ $category->name }}"
                                             class="img-thumbnail"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 80px; height: 80px;">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ $category->name }}</h6>
                                    @if($category->description)
                                        <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ $category->products_count }}</td>
                                <td>
                                    @if($category->parent)
                                        {{ $category->parent->name }}
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </td>
                                <td>{{ $category->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-folder2-open text-muted mb-2" style="font-size: 2rem;"></i>
                                        <h6 class="text-muted mb-2">No categories found</h6>
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                                            Add your first category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 