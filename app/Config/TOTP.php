<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class TOTP extends BaseConfig
{
    public string $issuer       = 'Halberd';
    public string $stylesheet   = 'css/totp.css';
    public int $secretKeyLength = 16;
}