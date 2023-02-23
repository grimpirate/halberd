<?php

declare(strict_types=1);

namespace GrimPirate\Halberd\Config;

use CodeIgniter\Config\BaseConfig;

class Halberd extends BaseConfig
{
    public string $issuer = 'Halberd';

    public array $views = [
        'action_register' => '\GrimPirate\Halberd\Views\register',
        'action_login'    => '\GrimPirate\Halberd\Views\login',
        'layout'          => '\GrimPirate\Halberd\Views\layout',
    ];
}
