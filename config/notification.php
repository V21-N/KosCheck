<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Configure which channels are enabled for notifications.
    | Channels: database, mail, vonage (Nexmo), twilio
    |
    */

    'channels' => [
        'database' => env('NOTIFICATION_DB_ENABLED', true),
        'mail' => env('NOTIFICATION_MAIL_ENABLED', false),
        'vonage' => env('NOTIFICATION_VONAGE_ENABLED', false),
        'twilio' => env('NOTIFICATION_TWILIO_ENABLED', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Notification Settings
    |--------------------------------------------------------------------------
    */
    'database' => [
        'retention_days' => env('NOTIFICATION_DB_RETENTION_DAYS', 90),
        'batch_size' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Notification Settings
    |--------------------------------------------------------------------------
    */
    'mail' => [
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@koscheck.id'),
        'from_name' => env('MAIL_FROM_NAME', 'KosCheck'),
        'bcc_lead_notifications' => env('NOTIFICATION_MAIL_BCC', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Vonage (Nexmo) SMS Settings
    |--------------------------------------------------------------------------
    */
    'vonage' => [
        'api_key' => env('VONAGE_API_KEY'),
        'api_secret' => env('VONAGE_API_SECRET'),
        'from' => env('VONAGE_FROM', 'KosCheck'),
        'enabled' => env('NOTIFICATION_VONAGE_ENABLED', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Twilio SMS Settings
    |--------------------------------------------------------------------------
    */
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
        'enabled' => env('NOTIFICATION_TWILIO_ENABLED', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Triggers
    |--------------------------------------------------------------------------
    */
    'triggers' => [
        'new_lead' => [
            'email' => true,
            'database' => true,
            'sms' => false,
            'batch_interval' => 5, // Send email every 5 leads
        ],
        'new_review' => [
            'email' => true,
            'database' => true,
            'sms' => false,
        ],
        'lead_quota_warning' => [
            'email' => true,
            'database' => true,
            'sms' => true,
        ],
        'kos_approved' => [
            'email' => true,
            'database' => true,
            'sms' => false,
        ],
        'kos_rejected' => [
            'email' => true,
            'database' => true,
            'sms' => false,
        ],
        'review_reported' => [
            'email' => true,
            'database' => true,
            'sms' => false,
            'admins_only' => true,
        ],
    ],

];