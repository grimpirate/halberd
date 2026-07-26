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
            'actions' => [
                'register' => \GrimPirate\Halberd\Authentication\Actions\TotpActivator::class,
                'login'    => \GrimPirate\Halberd\Authentication\Actions\TotpActivator::class,
            ],
            'authenticators' => [
                'totp' => \GrimPirate\Halberd\Authentication\Authenticators\Totp::class,
            ],
        ];
    }

    public static function AuthGroups(): array
    {
        helper('configgle');
        return [
            'permissions' => [
                configgle('Totp.permission') => lang('Totp.permission'),
            ],
        ];
    }
}