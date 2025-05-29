@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <h1 class="h3">Admin Login</h1>
                <p class="text-muted">Sign in to access the admin dashboard</p>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" 
                                required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </button>
                        </div>

                        @if (Route::has('admin.password.request'))
                            <div class="text-center">
                                <a class="text-decoration-none" href="{{ route('admin.password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 