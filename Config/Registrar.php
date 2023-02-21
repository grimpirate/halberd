<?php

namespace Halberd\Config;

class Registrar
{
    // Classes for Halberd module
    public static function Auth(): array
    {
        return [
            'views' => [
                'action_qrcode_activate_show'  => '\Halberd\Views\qrcode_activate_show',
                'action_qrcode_2fa_verify'  => '\Halberd\Views\qrcode_2fa_verify',
                'qrcode_layout'  => '\Halberd\Views\qrcode_layout',
            ],
            'actions' => [
                'register' => 'Halberd\Authentication\Actions\QRCodeActivator',
                'login' => 'Halberd\Authentication\Actions\QRCode2FA',
            ],
        ];
    }

    // Enable authorization on all routes except login, register, and auth
    public static function Filters(): array
    {
        return ['globals' => ['before' => ['session' => ['except' => ['login*', 'register', 'auth/a/*']]]]];
    }
}
