<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Information</title>
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --success-color: #10b981;
            --error-color: #ef4444;
            --text-color: #111827;
            --light-text: #6b7280;
            --border-color: #e5e7eb;
            --background-color: #f9fafb;
            --card-bg: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .profile-section {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 32px;
            width: 100%;
            max-width: 640px;
        }
        
        .profile-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-color);
        }
        
        .profile-header p {
            color: var(--light-text);
            font-size: 14px;
            margin-top: 8px;
        }
        
        .form-group {
            margin-top: 24px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 13px;
            margin-top: 8px;
        }
        
        .verification-notice {
            margin-top: 12px;
            font-size: 14px;
            color: var(--text-color);
        }
        
        .verification-link {
            color: var(--primary-color);
            text-decoration: underline;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .verification-link:hover {
            color: var(--primary-hover);
        }
        
        .success-message {
            color: var(--success-color);
            font-size: 14px;
            font-weight: 500;
            margin-top: 12px;
        }
        
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
        }
        
        .save-button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .save-button:hover {
            background-color: var(--primary-hover);
        }
        
        .saved-message {
            color: var(--light-text);
            font-size: 14px;
            opacity: 1;
            transition: opacity 0.5s ease;
        }
        
        @media (max-width: 640px) {
            .profile-section {
                padding: 24px;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </header>

        <div class="card-body">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
        </form>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', auth()->user()->name) }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                        value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                        <div class="alert alert-warning mt-2">
                            <p class="mb-0">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
            </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success mt-2">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </div>
                        @endif
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>

                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success ms-3 mb-0 py-2">
                            {{ __('Saved.') }}
                        </div>
                    @endif
                </div>
            </form>
            </div>
    </section>

    <script>
        // Simulate form submission and messages
        document.addEventListener('DOMContentLoaded', function() {
            const saveButton = document.querySelector('.save-button');
            const savedMessage = document.getElementById('saved-message');
            const verificationLink = document.querySelector('.verification-link');
            const successMessage = document.querySelector('.success-message');
            
            // Simulate save action
            saveButton.addEventListener('click', function(e) {
                e.preventDefault();
                savedMessage.style.display = 'block';
                setTimeout(() => {
                    savedMessage.style.opacity = '0';
                    setTimeout(() => {
                        savedMessage.style.display = 'none';
                        savedMessage.style.opacity = '1';
                    }, 500);
                }, 2000);
            });
            
            // Simulate verification email resend
            verificationLink.addEventListener('click', function(e) {
                e.preventDefault();
                successMessage.style.display = 'block';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000);
            });
        });
    </script>
</body>
</html>