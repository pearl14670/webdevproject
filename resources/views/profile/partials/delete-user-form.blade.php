<div class="card-body">
    <div class="alert alert-danger">
        <h4 class="alert-heading">{{ __('Delete Account') }}</h4>
        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
    </div>

    <form method="post" action="{{ route('profile.destroy') }}" class="mt-3">
            @csrf
            @method('delete')

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" name="password" type="password" 
                class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                placeholder="{{ __('Enter your password to confirm') }}" required>
            @error('password', 'userDeletion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>

        <button type="submit" class="btn btn-danger" 
            onclick="return confirm('{{ __('Are you sure you want to delete your account?') }}')">
                    {{ __('Delete Account') }}
        </button>
    </form>
            </div>
