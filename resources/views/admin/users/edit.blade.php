@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Edit User</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('is_admin') is-invalid @enderror" 
                                    id="is_admin" name="is_admin" value="1" 
                                    {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_admin">
                                    Administrator Access
                                </label>
                                @if($user->is_admin)
                                    <div class="form-text text-info">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Unchecking this will remove administrator privileges
                                    </div>
                                @endif
                                @error('is_admin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password (optional)</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password">
                            <div class="form-text">Leave blank to keep current password</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation">
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Save Changes
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-link">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection