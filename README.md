# halberd
A CodeIgniter Google Two-Factor Authentication Module for Shield
## Prerequisites
Assumes *codeigniter4/shield:dev-develop* has been preinstalled by composer
```
composer require codeigniter4/shield:dev-develop
```
## Installation (composer)
```
composer require grimpirate/halberd:dev-main
```
## Configuration
In the application's *.env* file *halberd.issuer* denotes the string that will appear on the Google Authenticator app as follows: ISSUER(username)
```
halberd.issuer = 'ISSUER'
```