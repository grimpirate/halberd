<?php

namespace GrimPirate\Halberd\Config;

use PragmaRX\Google2FA\Support\Constants;
use CodeIgniter\Config\BaseConfig;

class Totp extends BaseConfig
{
    public string $algorithm          = Constants::SHA1;
    public int $oneTimePasswordLength = 6;
    public int $keyRegeneration       = 30;
    public int $window                = 1;
    public int $secretKeyLength       = 32; // Updated to reflect https://github.com/antonioribeiro/google2fa/releases/tag/v9.0.0
    public string $issuer             = 'Halberd';
    public string $permission         = 'mfa.halberd';
}