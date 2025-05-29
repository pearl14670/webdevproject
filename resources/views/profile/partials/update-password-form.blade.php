<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                <input id="current_password" name="current_password" type="password" 
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                    autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input id="password" name="password" type="password" 
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                    autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password" 
                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                    autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

            <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Save') }}
                </button>

            @if (session('status') === 'password-updated')
                    <div class="alert alert-success ms-3 mb-0 py-2">
                        {{ __('Saved.') }}
                    </div>
            @endif
        </div>
    </form>
    </div>
</section>
