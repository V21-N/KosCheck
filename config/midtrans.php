<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk Midtrans Payment Gateway
    | Documentation: https://docs.midtrans.com
    |
    */

    // Server Key untuk backend (jangan公开!)
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-q-2U7wBL_qRZFiPxMIKeJeZb'),

    // Client Key untuk frontend (Snap JS)
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-5k6ZSkmI8Io0TUUO'),

    // Merchant ID (opsional, untuk beberapa integrasi)
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'M145294806'),

    // true untuk production, false untuk sandbox
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Enable sanitization
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    // Enable 3D Secure
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
