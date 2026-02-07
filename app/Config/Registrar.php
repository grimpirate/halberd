<?php

namespace Config;

class Registrar
{
    public static function Auth(): array
    {
        return [
            'actions' => [
                'register' => \GrimPirate\Halberd\Authentication\Actions\TOTPActivator::class,
                'login'    => \GrimPirate\Halberd\Authentication\Actions\TOTPActivator::class,
            ],
        ];
    }
}