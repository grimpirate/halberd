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
        'tidy' => [
            'description' => "Removes unneeded files from Halberd package.",
            'usage' => 'halberd:tidy',
        ],
    ],

    'permission' => 'Enables the TOTP Halberd module',

    'exception' => [
        'user' => 'Cannot get the User.',
        'pending' => 'Cannot get the pending login User.',
    ],

    'config' => [
        'exception' => [
            'authenticator' => 'Must be a non-empty string.',
            'issuer' => 'Must be a non-empty string.',
            'keyRegeneration' => 'Must be an integer greater than 0.',
            'oneTimePasswordLength' => 'Must be an integer greater than 0.',
            'permission' => 'Must be a non-empty string in AuthGroups $permissions configuration.',
            'view' => 'Must be a non-empty string.',
            'window' => 'Must be an integer greater than 0.',
        ],
        'warning' => [
            'keyRegeneration' => 'For largest compatibility with authenticator apps, this value should be kept at 30.',
        ],
    ],
];
