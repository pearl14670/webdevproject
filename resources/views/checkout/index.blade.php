@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Checkout') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                        @csrf

                        <!-- Shipping Address -->
                        <h5 class="mb-3">{{ __('Shipping Address') }}</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label for="shipping_name" class="form-label">{{ __('Full Name') }}</label>
                                <input type="text" class="form-control @error('shipping_address.name') is-invalid @enderror" 
                                       id="shipping_name" name="shipping_address[name]" required
                                       value="{{ old('shipping_address.name', $shippingAddress['name']) }}" readonly>
                                @error('shipping_address.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="shipping_address" class="form-label">{{ __('Address') }}</label>
                                <input type="text" class="form-control @error('shipping_address.address') is-invalid @enderror" 
                                       id="shipping_address" name="shipping_address[address]" required
                                       value="{{ old('shipping_address.address', $shippingAddress['address']) }}" readonly>
                                @error('shipping_address.address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <input type="text" class="form-control mt-2" 
                                       id="shipping_address2" name="shipping_address[address2]"
                                       placeholder="Apartment, suite, unit etc. (optional)">
                            </div>

                            <div class="col-md-6">
                                <label for="shipping_city" class="form-label">{{ __('City') }}</label>
                                <input type="text" class="form-control @error('shipping_address.city') is-invalid @enderror" 
                                       id="shipping_city" name="shipping_address[city]" required
                                       value="{{ old('shipping_address.city', $shippingAddress['city']) }}" readonly>
                                @error('shipping_address.city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="shipping_state" class="form-label">{{ __('State') }}</label>
                                <input type="text" class="form-control @error('shipping_address.state') is-invalid @enderror" 
                                       id="shipping_state" name="shipping_address[state]" required
                                       value="{{ old('shipping_address.state', $shippingAddress['state']) }}" readonly>
                                @error('shipping_address.state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="shipping_postal_code" class="form-label">{{ __('Postal Code') }}</label>
                                <input type="text" class="form-control @error('shipping_address.postal_code') is-invalid @enderror" 
                                       id="shipping_postal_code" name="shipping_address[postal_code]" required
                                       value="{{ old('shipping_address.postal_code', $shippingAddress['postal_code']) }}" readonly>
                                @error('shipping_address.postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="shipping_country" class="form-label">{{ __('Country') }}</label>
                                <input type="text" class="form-control @error('shipping_address.country') is-invalid @enderror" 
                                       id="shipping_country" name="shipping_address[country]" required
                                       value="{{ old('shipping_address.country', $shippingAddress['country']) }}" readonly>
                                @error('shipping_address.country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="shipping_phone" class="form-label">{{ __('Phone') }}</label>
                                <input type="tel" class="form-control @error('shipping_address.phone') is-invalid @enderror" 
                                       id="shipping_phone" name="shipping_address[phone]" required
                                       value="{{ old('shipping_address.phone', $shippingAddress['phone']) }}" readonly>
                                @error('shipping_address.phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <h5 class="mb-3">{{ __('Billing Address') }}</h5>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="same_as_shipping" checked>
                                <label class="form-check-label" for="same_as_shipping">
                                    {{ __('Same as shipping address') }}
                                </label>
                            </div>
                        </div>

                        <div id="billing_address_fields" class="row g-3 mb-4" style="display: none;">
                            <div class="col-12">
                                <label for="billing_name" class="form-label">{{ __('Full Name') }}</label>
                                <input type="text" class="form-control @error('billing_address.name') is-invalid @enderror" 
                                       id="billing_name" name="billing_address[name]" required
                                       pattern="^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$"
                                       title="Please enter a valid name">
                                @error('billing_address.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="billing_address" class="form-label">{{ __('Address') }}</label>
                                <input type="text" class="form-control @error('billing_address.address') is-invalid @enderror" 
                                       id="billing_address" name="billing_address[address]" required
                                       placeholder="Street address">
                                @error('billing_address.address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <input type="text" class="form-control mt-2" 
                                       id="billing_address2" name="billing_address[address2]"
                                       placeholder="Apartment, suite, unit etc. (optional)">
                            </div>

                            <div class="col-md-6">
                                <label for="billing_city" class="form-label">{{ __('City') }}</label>
                                <input type="text" class="form-control @error('billing_address.city') is-invalid @enderror" 
                                       id="billing_city" name="billing_address[city]" required>
                                @error('billing_address.city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="billing_state" class="form-label">{{ __('State') }}</label>
                                <input type="text" class="form-control @error('billing_address.state') is-invalid @enderror" 
                                       id="billing_state" name="billing_address[state]" required>
                                @error('billing_address.state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="billing_postal_code" class="form-label">{{ __('Postal Code') }}</label>
                                <input type="text" class="form-control @error('billing_address.postal_code') is-invalid @enderror" 
                                       id="billing_postal_code" name="billing_address[postal_code]" required>
                                @error('billing_address.postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="billing_country" class="form-label">{{ __('Country') }}</label>
                                <select class="form-select @error('billing_address.country') is-invalid @enderror" 
                                        id="billing_country" name="billing_address[country]" required>
                                    <option value="">Choose...</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="AU">Australia</option>
                                    <option value="DE">Germany</option>
                                    <option value="FR">France</option>
                                    <!-- Add more countries as needed -->
                                </select>
                                @error('billing_address.country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="billing_phone" class="form-label">{{ __('Phone') }}</label>
                                <input type="tel" class="form-control @error('billing_address.phone') is-invalid @enderror" 
                                       id="billing_phone" name="billing_address[phone]" required
                                       pattern="^\+?[1-9]\d{1,14}$"
                                       title="Please enter a valid phone number">
                                @error('billing_address.phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        <h5 class="mb-3">{{ __('Shipping Method') }}</h5>
                        <div class="mb-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="shipping_method" 
                                       id="shipping_standard" value="standard" checked>
                                <label class="form-check-label" for="shipping_standard">
                                    {{ __('Standard Shipping') }} - $5.00 (5-7 business days)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shipping_method" 
                                       id="shipping_express" value="express">
                                <label class="form-check-label" for="shipping_express">
                                    {{ __('Express Shipping') }} - $15.00 (2-3 business days)
                                </label>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <h5 class="mb-3">{{ __('Payment Method') }}</h5>
                        <div class="mb-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="payment_credit_card" value="credit_card" checked>
                                <label class="form-check-label" for="payment_credit_card">
                                    {{ __('Credit Card') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="payment_paypal" value="paypal">
                                <label class="form-check-label" for="payment_paypal">
                                    {{ __('PayPal') }}
                                </label>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <h5 class="mb-3">{{ __('Order Notes') }}</h5>
                        <div class="mb-4">
                            <textarea class="form-control" name="notes" rows="3" 
                                      placeholder="{{ __('Special notes for delivery (optional)') }}"></textarea>
                        </div>

                        <!-- Hidden billing address fields -->
                        <input type="hidden" name="billing_address[name]" value="{{ $billingAddress['name'] }}">
                        <input type="hidden" name="billing_address[address]" value="{{ $billingAddress['address'] }}">
                        <input type="hidden" name="billing_address[city]" value="{{ $billingAddress['city'] }}">
                        <input type="hidden" name="billing_address[state]" value="{{ $billingAddress['state'] }}">
                        <input type="hidden" name="billing_address[postal_code]" value="{{ $billingAddress['postal_code'] }}">
                        <input type="hidden" name="billing_address[country]" value="{{ $billingAddress['country'] }}">
                        <input type="hidden" name="billing_address[phone]" value="{{ $billingAddress['phone'] }}">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" onclick="this.disabled=true;this.form.submit();">
                                {{ __('Place Order') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Order Summary') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                @foreach($cart->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->product->name }}
                                            <br>
                                            <small class="text-muted">{{ __('Qty:') }} {{ $item->quantity }}</small>
                                        </td>
                                        <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><strong>{{ __('Subtotal') }}</strong></td>
                                    <td class="text-end"><strong>${{ number_format($cart->total, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
    const shippingAddressInput = document.getElementById('shipping_address');
    const billingAddressInput = document.getElementById('billing_address');
    
    if (shippingAddressInput) {
        const placesShipping = places({
            appId: '{{ config('services.algolia.places.app_id') }}',
            apiKey: '{{ config('services.algolia.places.api_key') }}',
            container: shippingAddressInput
        });

        placesShipping.on('change', function(e) {
            document.getElementById('shipping_city').value = e.suggestion.city || '';
            document.getElementById('shipping_state').value = e.suggestion.administrative || '';
            document.getElementById('shipping_postal_code').value = e.suggestion.postcode || '';
            document.getElementById('shipping_country').value = e.suggestion.countryCode.toUpperCase() || '';
        });
    }

    if (billingAddressInput) {
        const placesBilling = places({
            appId: '{{ config('services.algolia.places.app_id') }}',
            apiKey: '{{ config('services.algolia.places.api_key') }}',
            container: billingAddressInput
        });

        placesBilling.on('change', function(e) {
            document.getElementById('billing_city').value = e.suggestion.city || '';
            document.getElementById('billing_state').value = e.suggestion.administrative || '';
            document.getElementById('billing_postal_code').value = e.suggestion.postcode || '';
            document.getElementById('billing_country').value = e.suggestion.countryCode.toUpperCase() || '';
        });
    }

    // Handle same as shipping checkbox
    const sameAsShippingCheckbox = document.getElementById('same_as_shipping');
    const billingAddressFields = document.getElementById('billing_address_fields');

    function copyShippingToBilling() {
        if (sameAsShippingCheckbox.checked) {
            document.getElementById('billing_name').value = document.getElementById('shipping_name').value;
            document.getElementById('billing_address').value = document.getElementById('shipping_address').value;
            document.getElementById('billing_address2').value = document.getElementById('shipping_address2').value;
            document.getElementById('billing_city').value = document.getElementById('shipping_city').value;
            document.getElementById('billing_state').value = document.getElementById('shipping_state').value;
            document.getElementById('billing_postal_code').value = document.getElementById('shipping_postal_code').value;
            document.getElementById('billing_country').value = document.getElementById('shipping_country').value;
            document.getElementById('billing_phone').value = document.getElementById('shipping_phone').value;
            billingAddressFields.style.display = 'none';
        } else {
            billingAddressFields.style.display = 'flex';
        }
    }

    if (sameAsShippingCheckbox) {
        sameAsShippingCheckbox.addEventListener('change', copyShippingToBilling);
        copyShippingToBilling(); // Initial state
    }

    // Postal code validation based on country
    function validatePostalCode(countrySelect, postalInput) {
        const patterns = {
            'US': '^\\d{5}(-\\d{4})?$',
            'CA': '^[A-Za-z]\\d[A-Za-z] ?\\d[A-Za-z]\\d$',
            'GB': '^[A-Z]{1,2}\\d[A-Z\\d]? ?\\d[A-Z]{2}$',
            'AU': '^\\d{4}$',
            'DE': '^\\d{5}$',
            'FR': '^\\d{5}$'
        };

        countrySelect.addEventListener('change', function() {
            const pattern = patterns[this.value];
            if (pattern) {
                postalInput.pattern = pattern;
            } else {
                postalInput.pattern = '.*';
            }
        });
    }

    validatePostalCode(
        document.getElementById('shipping_country'),
        document.getElementById('shipping_postal_code')
    );
    validatePostalCode(
        document.getElementById('billing_country'),
        document.getElementById('billing_postal_code')
    );

    // Form validation
    const form = document.getElementById('checkoutForm');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endpush 