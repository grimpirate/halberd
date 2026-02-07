# Halberd
A TOTP (Time-Based One-Time Password) Two-Factor Authentication Module for [codeigniter4/shield](https://github.com/codeigniter4/shield)
## Installation
Project should have a stability level of dev
```
composer config minimum-stability dev
composer config prefer-stable true
composer require grimpirate/halberd:dev-develop
```
## Configuration - CLI method
```
php spark halberd:ini
```
## Configuration - Manual method
Copy/merge the registrar file from **vendor/grimpirate/halberd/app/Config/Registrar.php** to your project's **app/Config/** directory
## Remarks
1. `php spark halberd:ini` will silently fail to copy Registrar.php to **app/Config/** if it already exists in the  directory.
2. The dependency [pragmarx/google2fa](https://github.com/antonioribeiro/google2fa?tab=readme-ov-file#server-time) requires that your server time be accurately synchronized (via NTP or some other means).
3. CodeIgniter's [appTimezone](https://github.com/codeigniter4/CodeIgniter4/blob/655bd1de0c460b0e1353d2ead8ecff956ac08ccc/app/Config/App.php#L136) will not affect OTP generation.
4. Requires php [xmlwriter](https://www.php.net/manual/en/book.xmlwriter.php) extension.