<?php

namespace Config;

class Registrar
{
    public static function Auth(): array
    {
        return [
            'views' => [
                'action_totp_2fa' => '\GrimPirate\Halberd\Views\totp_2fa_show',
            ],
            'actions' => [
                'register' => \GrimPirate\Halberd\Authentication\Actions\TOTPActivator::class,
                'login'    => \GrimPirate\Halberd\Authentication\Actions\TOTPActivator::class,
            ],
            'authenticators' => [
                'totp' => \GrimPirate\Halberd\Authentication\Authenticators\TOTP::class,
            ],
        ];
    }
}