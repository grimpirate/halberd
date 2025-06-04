# Halberd
A TOTP (Time-Based One-Time Password) Two-Factor Authentication Module for [codeigniter4/shield](https://github.com/codeigniter4/shield)
## Installation
Project should have a stability level of dev
```
composer config minimum-stability dev
composer config prefer-stable true
composer require grimpirate/halberd:dev-develop
```
## Configuration
1. Copy the configuration file from **vendor/grimpirate/halberd/app/Config/TOTP.php** to your project's **app/Config/** directory
2. The register/login actions and the TOTP authenticator class must be added to the Config/Auth file
```
...

class Auth extends BaseConfig
{

  ...

  public array $actions = [
    'register' => '\GrimPirate\Halberd\Authentication\Actions\TOTPActivator',
    'login'    => '\GrimPirate\Halberd\Authentication\Actions\TOTPActivator',
  ];

  ...

  public array $authenticators = [
    ...
    'totp'    => \GrimPirate\Halberd\Authentication\Authenticators\TOTP::class,
  ];

  ...
```
## Dependencies
The dependency [pragmarx/google2fa](https://github.com/antonioribeiro/google2fa?tab=readme-ov-file#server-time) requires that your server time be accurately synchronized (via NTP or some other means). CodeIgniter's [appTimezone](https://github.com/codeigniter4/CodeIgniter4/blob/655bd1de0c460b0e1353d2ead8ecff956ac08ccc/app/Config/App.php#L136) will not affect OTP generation.
## Styles
The QR Code will not be visible without creating a stylesheet and applying some basic styles, for instance
```
svg
{
  width: 100%;
  height: 240px;
  fill-rule: evenodd;
}
```
