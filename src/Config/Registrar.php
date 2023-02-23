<?php

namespace GrimPirate\Halberd\Config;

class Registrar
{
    // Classes for Halberd module
    public static function Auth(): array
    {
        return [
            'actions' => [
                'register' => 'GrimPirate\Halberd\Authentication\Actions\Register',
                'login'    => 'GrimPirate\Halberd\Authentication\Actions\Login',
            ],
        ];
    }

    // Enable authorization on all routes except login, register, and auth
    /*public static function Filters(): array
    {
        return ['globals' => ['before' => ['session' => ['except' => ['login*', 'register', 'auth/a/*']]]]];
    }*/
}
