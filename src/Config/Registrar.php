<?php

namespace GrimPirate\Halberd\Config;

use GrimPirate\Halberd\Authentication\Authenticators\Totp;

class Registrar
{
    public static function Auth(): array
    {
        return [
            'views' => [
                Totp::ACTION_TOTP_2FA => '\GrimPirate\Halberd\Views\totp_2fa_show',
            ],
            'actions' => [
                'register' => \GrimPirate\Halberd\Authentication\Actions\TotpActivator::class,
                'login'    => \GrimPirate\Halberd\Authentication\Actions\TotpActivator::class,
            ],
            'authenticators' => [
                setting('Totp.authenticator') => \GrimPirate\Halberd\Authentication\Authenticators\Totp::class,
            ],
        ];
    }

    public static function AuthGroups(): array
    {
        return [
            'permissions' => [
                setting('Totp.permission') => lang('Totp.permission'),
            ],
        ];
    }
}