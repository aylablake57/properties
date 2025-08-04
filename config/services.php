<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id'     => '435772380985-fanedfb8pglbcotokonfvfmgf162n7lc.apps.googleusercontent.com', //'900994496503-m72tgm9g2n0haj02aet32bmsgbgs566b.apps.googleusercontent.com',
        'client_secret' => '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', //'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',
        'redirect'  => 'https://dha360.pk/auth/google/callback',
    ],

    'facebook' => [
        'client_id'     => '888613483105988',  // '1605008620278631',
        'client_secret' => '1e8175eb94c0cab40424fa4de8cc4364', // '3a8f90dc27cb78a6c1c6263ca3e8261f',
        'redirect'  => 'https://dha360.pk/auth/facebook/callback',
    ],

    'recpatcha' => [
        'site_key'     => env('RECAPTCHAV3_SITEKEY'),
        'secret_key' => env('RECAPTCHAV3_SECRET'),
    ],

    'whatsapp' => [
        'number' => env('WHATSAPP_NUMBER'),
    ]

];
