<?php

namespace Config;

class Registrar
{
    public static function Auth(): array
    {
        return [
            'actions' => [
                'register' => \GrimPirate\Halberd\Authentication\Actions\TotpActivator::class,
                'login'    => \GrimPirate\Halberd\Authentication\Actions\TotpActivator::class,
            ],
        ];
    }
}