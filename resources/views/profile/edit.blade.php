@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Profile Settings') }}</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <h5 class="mb-3">{{ __('Basic Information') }}</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Default Address -->
                        <h5 class="mb-3">{{ __('Default Address') }}</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="default_address" class="form-label">{{ __('Address') }}</label>
                                <input type="text" class="form-control @error('default_address') is-invalid @enderror" 
                                       id="default_address" name="default_address" 
                                       value="{{ old('default_address', $user->default_address) }}" required
                                       placeholder="Street address">
                                @error('default_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="default_city" class="form-label">{{ __('City') }}</label>
                                <input type="text" class="form-control @error('default_city') is-invalid @enderror" 
                                       id="default_city" name="default_city" 
                                       value="{{ old('default_city', $user->default_city) }}" required>
                                @error('default_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="default_state" class="form-label">{{ __('State') }}</label>
                                <input type="text" class="form-control @error('default_state') is-invalid @enderror" 
                                       id="default_state" name="default_state" 
                                       value="{{ old('default_state', $user->default_state) }}" required>
                                @error('default_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="default_postal_code" class="form-label">{{ __('Postal Code') }}</label>
                                <input type="text" class="form-control @error('default_postal_code') is-invalid @enderror" 
                                       id="default_postal_code" name="default_postal_code" 
                                       value="{{ old('default_postal_code', $user->default_postal_code) }}" required>
                                @error('default_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="default_country" class="form-label">{{ __('Country') }}</label>
                                <select class="form-select @error('default_country') is-invalid @enderror" 
                                        id="default_country" name="default_country" required>
                                    <option value="">Choose...</option>
                                    <option value="US" {{ old('default_country', $user->default_country) == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('default_country', $user->default_country) == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="GB" {{ old('default_country', $user->default_country) == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="AU" {{ old('default_country', $user->default_country) == 'AU' ? 'selected' : '' }}>Australia</option>
                                    <option value="DE" {{ old('default_country', $user->default_country) == 'DE' ? 'selected' : '' }}>Germany</option>
                                    <option value="FR" {{ old('default_country', $user->default_country) == 'FR' ? 'selected' : '' }}>France</option>
                                </select>
                                @error('default_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="default_phone" class="form-label">{{ __('Phone') }}</label>
                                <input type="tel" class="form-control @error('default_phone') is-invalid @enderror" 
                                       id="default_phone" name="default_phone" 
                                       value="{{ old('default_phone', $user->default_phone) }}" required>
                                @error('default_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize address autocomplete
    const addressInput = document.getElementById('default_address');
    
    if (addressInput) {
        const places = window.places({
            appId: '{{ config('services.algolia.places.app_id') }}',
            apiKey: '{{ config('services.algolia.places.api_key') }}',
            container: addressInput
        });

        places.on('change', function(e) {
            document.getElementById('default_city').value = e.suggestion.city || '';
            document.getElementById('default_state').value = e.suggestion.administrative || '';
            document.getElementById('default_postal_code').value = e.suggestion.postcode || '';
            document.getElementById('default_country').value = e.suggestion.countryCode.toUpperCase() || '';
        });
    }
});
</script>
@endpush
