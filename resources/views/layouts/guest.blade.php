<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Custom CSS -->
        <style>
            .min-vh-85 {
                min-height: 85vh;
            }
            .form-control:focus {
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            }
            .card {
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body class="bg-light">
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center mb-4">
                            <a href="/" class="text-decoration-none">
                                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap Bundle JS (includes Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <!-- Custom JS -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
