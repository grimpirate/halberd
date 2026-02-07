<?php

namespace GrimPirate\Halberd\Config;

class Registrar
{
    public static function Auth(): array
    {
        return [
            'views' => [
                'action_totp_2fa' => '\GrimPirate\Halberd\Views\totp_2fa_show',
            ],
            'authenticators' => [
                'totp' => \GrimPirate\Halberd\Authentication\Authenticators\Totp::class,
            ],
        ];
    }
}