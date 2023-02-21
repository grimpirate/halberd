# halberd
A CodeIgniter Google Two-Factor Authentication Module for Shield
## Installation
```
cd {codeigniter-directory}

composer require pragmarx/google2fa --working-dir=ci4
composer require bacon/bacon-qr-code --working-dir=ci4

wget https://github.com/grimpirate/halberd/archive/main.tar.gz
tar -xzf main.tar.gz

mkdir -p app/Modules
mv halberd-main app/Modules/halberd

rm main.tar.gz app/Modules/halberd/LICENSE app/Modules/halberd/README.md
```
## Configuration
Add the following namespace to the *$psr4* array in *Config/Autoload.php*
```
'Halberd' => APPPATH . 'Modules/halberd/'
```
**OR** via command line
```
sed -i "s/public \$psr4 = \[/public \$psr4 = [\n\t'Halberd'     => APPPATH . 'Modules\/halberd\/',/" app/Config/Autoload.php
```
