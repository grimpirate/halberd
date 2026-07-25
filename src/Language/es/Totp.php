<?php

return [
    // 2FA
    'title2FA'    => 'Verificación de Doble Factor',
    'confirmCode' => 'Ingrese el código de 6 dígitos de su aplicación.',

    // Register
    'googleApp'  => 'Escanea este código QR utilizando una aplicación de verificación de doble factor (<a href="{android}" target="_blank">Android</a>/<a href="{ios}" target="_blank">iOS</a>) e ingrese una contraseña única (OTP) para activar su cuenta.',
    'android' => 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=es',
    'ios' => 'https://apps.apple.com/es/app/google-authenticator/id388497605',
    'problems'  => '¿No puede escanear? Ingrese la clave de configuración manualmente <strong>{placeholder}</strong> en su aplicación.',

    // Spark commands
    'spark' => [
        'initialize' => [
            'description' => 'Inicializa los parámetros de configuración para Halberd.',
            'usage' => 'halberd:ini',
        ],
        'totp' => [
            'input' => [
                'id' => 'ID?',
            ],
            'description' => 'Anula la identidad TOTP del usuario.',
            'usage' => 'halberd:totp <id>',
            'arguments' => [
                'id' => 'ID del usuario',
            ],
        ],
    ],

    'config' => [
        'exception' => [
            'oneTimePasswordLength' => 'Debe ser un número entero mayor que 0.',
            'keyRegeneration' => 'Debe ser un número entero mayor que 0.',
            'window' => 'Debe ser un número entero mayor que 0.',
            'issuer' => 'Debe ser una cadena no vacía.',
            'permission' => 'Debe ser una cadena no vacía en la configuración de $permissions de AuthGroups.'
        ],
        'warning' => [
            'keyRegeneration' => 'Para garantizar la mayor compatibilidad con aplicaciones de autenticación, este valor debe mantenerse en 30.',
        ],
    ],
];
