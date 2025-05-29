<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cart Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify cart-related settings.
    |
    */

    // Tax rate in percentage (e.g., 10 for 10%)
    'tax_rate' => env('CART_TAX_RATE', 10),

    // Maximum quantity allowed per item
    'max_quantity_per_item' => env('CART_MAX_QUANTITY_PER_ITEM', 10),

    // Cart session lifetime in minutes
    'session_lifetime' => env('CART_SESSION_LIFETIME', 60 * 24), // 24 hours
]; 