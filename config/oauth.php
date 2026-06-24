<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third-Party OAuth Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains OAuth provider configurations for Google OAuth
    | and other providers if needed in the future.
    |
    */

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', '/auth/google/callback'),

        /*
        |--------------------------------------------------------------------------
        | Role Mapping Strategy
        |--------------------------------------------------------------------------
        |
        | How should OAuth users be assigned roles?
        |
        | 'prompt'           - Always show role selection page (default for this app)
        | 'auto_mahasiswa'    - Auto-assign 'mahasiswa' role to all OAuth users
        | 'domain_based'      - Auto-assign based on email domain
        |                       e.g., .ac.id = mahasiswa, koscheck.id = admin
        |
        */
        'role_strategy' => env('GOOGLE_ROLE_STRATEGY', 'prompt'),

        /*
        |--------------------------------------------------------------------------
        | Domain-Based Role Mapping
        |--------------------------------------------------------------------------
        |
        | When role_strategy is 'domain_based', these domains determine user roles.
        | Format: 'domain' => 'role'
        |
        */
        'domain_roles' => [
            // Academic domains = mahasiswa
            '.ac.id' => 'mahasiswa',
            '.edu' => 'mahasiswa',
            '.university' => 'mahasiswa',

            // KosCheck internal domains = admin
            'koscheck.id' => 'admin',
            'koscheck.com' => 'admin',

            // Default for unknown domains = mahasiswa
            'default' => 'mahasiswa',
        ],

        /*
        |--------------------------------------------------------------------------
        | Auto-Detected University Mapping
        |--------------------------------------------------------------------------
        |
        | Map Google email domains to university names for auto-filling
        | the 'university' field for mahasiswa users.
        |
        */
        'university_domains' => [
            'ugm.ac.id' => 'Universitas Gadjah Mada',
            'ui.ac.id' => 'Universitas Indonesia',
            'itb.ac.id' => 'Institut Teknologi Bandung',
            'ipb.ac.id' => 'Institut Pertanian Bogor',
            'unpad.ac.id' => 'Universitas Padjadjaran',
            'undip.ac.id' => 'Universitas Diponegoro',
            'unej.ac.id' => 'Universitas Jember',
            'unair.ac.id' => 'Universitas Airlangga',
            'its.ac.id' => 'Institut Teknologi Sepuluh Nopember',
            'unhas.ac.id' => 'Universitas Hasanuddin',
            'usu.ac.id' => 'Universitas Sumatera Utara',
            'unsyiah.ac.id' => 'Universitas Syiah Kuala',
            'unimal.ac.id' => 'Universitas Malikussaleh',
            'del.ac.id' => 'Institut Teknologi Del',
            'ug.ac.id' => 'Universitas Groningen (via ug.ac.id)',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | OAuth Callback URL Configuration
    |--------------------------------------------------------------------------
    |
    | The callback URL path for OAuth authentication.
    |
    */
    'callback_path' => '/auth/google/callback',

];
