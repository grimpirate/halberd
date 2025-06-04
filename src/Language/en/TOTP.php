<?php

return [
    // 2FA
    'title2FA'    => 'Two-Factor Authentication',
    'confirmCode' => 'Enter the 6-digit code from your authenticator app.',

    // Register
    'googleApp'  => 'Scan this QR code with a Two-Factor Authentication app (<a href="{android}" target="_blank">Android</a>/<a href="{ios}" target="_blank">iOS</a>) and enter a One-Time Password to activate your account.',
    'android' => 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2',
    'ios' => 'https://apps.apple.com/us/app/google-authenticator/id388497605',
    'problems'  => 'Unable to scan? Manually add the setup key <strong>{placeholder}</strong> to your authenticator app.',

    // Spark commands
    'spark' => [
        'initialize' => [
            'input' => [
                'issuer' => 'Issuer?',
                'stylesheet' => 'CSS?',
            ],
            'description' => 'Initializes configuration parameters for Halberd.',
            'usage' => 'halberd:ini <issuer> <css>',
            'arguments' => [
                'issuer' => 'The One-Time Password (OTP) issuer',
                'stylesheet' => 'CSS stylesheet location for activation/authentication forms',
            ],
        ],
        'totp' => [
            'input' => [
                'id' => 'ID?',
            ],
            'description' => "Invalidates a user's TOTP identity.",
            'usage' => 'halberd:totp <id>',
            'arguments' => [
                'id' => 'User ID',
            ],
        ],
    ],
];
