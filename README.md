# halberd
A CodeIgniter Google Two-Factor Authentication Module for Shield
## Prerequisites
Project should have a stability level of dev
```
composer config minimum-stability dev
```
## Installation (composer)
```
composer require grimpirate/halberd:dev-develop
```
## Configuration
In the application's *.env* file *halberd.issuer* denotes the string that will appear on the Google Authenticator app as follows: ISSUER(username)
```
halberd.issuer = 'ISSUER'
```
