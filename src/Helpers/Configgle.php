<?php

use CodeIgniter\Exceptions\ConfigException;

if (!function_exists('configgle'))
{
    function configgle(string $key)
    {
        return match($key)
        {
            // throws \PragmaRX\Google2FA\Exceptions\InvalidAlgorithmException
            'Totp.algorithm',
            // throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
            // throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
            // throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
            'Totp.secretKeyLength' => setting($key),
            'Totp.oneTimePasswordLength',
            'Totp.window' => (function($num) use ($key) {
                $num = filter_var($num, FILTER_VALIDATE_INT);
                if(
                    $num === false
                    || $num < 1
                )
                    throw new ConfigException(lang("Totp.config.exception.{$key}"));

                return $num;
            })(setting($key)),
            'Totp.keyRegeneration' => (function($num) use ($key) {
                $num = filter_var($num, FILTER_VALIDATE_INT);
                if(
                    $num === false
                    || $num < 1
                )
                    throw new ConfigException(lang("Totp.config.exception.{$key}"));
                
                // Issue 30 second warning based on https://github.com/antonioribeiro/google2fa#key-regeneration-interval
                if($num != 30)
                    log_message('warning', lang("Totp.config.warning.{$key}"));

                return $num;
            })(setting($key)),
            'Totp.issuer' => (function($str) user ($key) {
                if(
                    empty($str)
                    || !is_string($str)
                )
                    throw new ConfigException(lang("Totp.config.exception.{$key}"));

                return $str;                
            })(setting($key)),
            'Totp.permission' => (function($str) user ($key) {
                $permissions = array_keys(setting('AuthGroups.permissions'));
                if(
                    empty($str)
                    || !is_string($str)
                    || array_search($str, $permissions, true) === false
                )
                    throw new ConfigException(lang("Totp.config.exception.{$key}"));
                
                return $str;
            })(setting($key)),
        }
    }


}