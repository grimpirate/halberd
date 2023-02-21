# halberd
A CodeIgniter Google Two-Factor Authentication Module for Shield
## Installation
Assumes *ci4/* is the directory that contains *app/* and *vendor/*
```
composer require pragmarx/google2fa --working-dir=ci4
composer require bacon/bacon-qr-code --working-dir=ci4

wget https://github.com/grimpirate/halberd/archive/main.tar.gz
tar -xzf main.tar.gz
rm main.tar.gz halberd-main/LICENSE halberd-main/README.md

mkdir -p ci4/app/Modules
mv halberd-main ci4/app/Modules/halberd
```
## Configuration
Add the following namespace to the *$psr4* array in *ci4/app/Config/Autoload.php*
```
'Halberd' => APPPATH . 'Modules/halberd/'
```
**OR** via command line
```
sed -i "s/public \$psr4 = \[/public \$psr4 = [\n\t'Halberd'     => APPPATH . 'Modules\/halberd\/',/" ci4/app/Config/Autoload.php
```
