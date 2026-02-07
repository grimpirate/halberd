<?php

namespace GrimPirate\Halberd\Config;

use CodeIgniter\Config\BaseConfig;

class Totp extends BaseConfig
{
    public string $issuer       = 'Halberd';
    public int $secretKeyLength = 16;
}