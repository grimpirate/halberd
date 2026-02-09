<?php

namespace GrimPirate\Halberd\Config;

use CodeIgniter\Config\BaseConfig;

class Totp extends BaseConfig
{
    public string $issuer       = 'Halberd';
    public int $secretKeyLength = 32; // Updated to reflect https://github.com/antonioribeiro/google2fa/releases/tag/v9.0.0
}