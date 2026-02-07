<?php

namespace Grimpirate\Halberd\Config;

use CodeIgniter\Config\BaseConfig;

class TOTP extends BaseConfig
{
    public string $issuer       = 'Halberd';
    public int $secretKeyLength = 16;
}