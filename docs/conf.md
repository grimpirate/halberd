---
icon: lucide/settings
---

# Configuration

## .env

```
totp.algorithm             = 'sha1'
totp.oneTimePasswordLength = 6
totp.keyRegeneration       = 30
totp.window                = 1
totp.secretKeyLength       = 32
totp.issuer                = 'Halberd'
totp.permission            = 'mfa.halberd'
totp.authenticator         = 'totp'
```

## AuthGroups

Create/add a multi-factor authentication group and assign it to users (or add the permission individually on a per-user basis). This permits creation of an opt-in system. The permission string should match the value in the *.env* file (default is *mfa.halberd*).

``` php title="app/Config/AuthGroups.php"
public array $groups = [

	...

	'mfa' => [
		'title'       => 'Multi-Factor Authentication',
		'description' => 'Users that have opted into multi-factor authentication',
	],
];

public array $matrix = [

	...

	'mfa' => [
		'mfa.halberd',
	],
];
```

## Events

Adding a user to the *mfa* group upon registration will prompt them to initialize their chosen multi-factor authentication application by scanning a QR Code.

!!! note

	Halberd displays the initialization screen on register/login only if the user's account is not activated.

``` php title="app/Config/Events.php"
Events::on('register', function($user): void {
    // Forces all newly registered users into the 'mfa' group
    $user->addGroup('mfa');
});
```