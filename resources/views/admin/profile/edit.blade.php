@extends('layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                <div class="card-header">
                    <h2 class="mb-0">Admin Profile</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <div class="text-center mb-4">
                                <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle p-4 d-inline-block mb-3">
                                    <i class="bi bi-person-badge fs-2"></i>
                                </div>
                                <h5 class="mb-1">Administrator Account</h5>
                                <p class="text-muted">Manage your admin profile details</p>
                            </div>
                        </div>

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
                            @if ($user->email_verified_at === null)
                                <div class="form-text text-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Your email address is not verified.
                                </div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input id="current_password" type="password" 
                                class="form-control @error('current_password') is-invalid @enderror" 
                                name="current_password">
                            <div class="form-text">Required only when changing password</div>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password">
                            <div class="form-text">Leave blank to keep current password</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation">
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Update Profile
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-link">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-danger bg-opacity-10 text-danger">
                    <h3 class="h5 mb-0">Danger Zone</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="h6 mb-1">Delete Account</h4>
                        <p class="text-muted mb-3">Permanently delete your admin account and all associated data.</p>
                        
                        <form method="POST" action="{{ route('admin.profile.destroy') }}" class="mt-3">
                            @csrf
                            @method('DELETE')

                            <div class="mb-3">
                                <label for="current_password_delete" class="form-label">Current Password</label>
                                <input id="current_password_delete" type="password" 
                                    class="form-control @error('current_password', 'userDeletion') is-invalid @enderror" 
                                    name="current_password">
                                @error('current_password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete your admin account? This action cannot be undone.');">
                                    <i class="bi bi-trash me-2"></i>Delete Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 