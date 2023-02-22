<?php

namespace GrimPirate\Halberd\Config;

class Registrar
{
    // Classes for Halberd module
    public static function Auth(): array
    {
        return [
            'views' => [
                'action_qrcode_activate_show'  => '\GrimPirate\Halberd\Views\qrcode_activate_show',
                'action_qrcode_2fa_verify'  => '\GrimPirate\Halberd\Views\qrcode_2fa_verify',
                'qrcode_layout'  => '\GrimPirate\Halberd\Views\qrcode_layout',
            ],
            'actions' => [
                'register' => 'GrimPirate\Halberd\Authentication\Actions\QRCodeActivator',
                'login' => 'GrimPirate\Halberd\Authentication\Actions\QRCode2FA',
            ],
        ];
    }

    // Enable authorization on all routes except login, register, and auth
    public static function Filters(): array
    {
        return ['globals' => ['before' => ['session' => ['except' => ['login*', 'register', 'auth/a/*']]]]];
    }
}
