---
icon: lucide/wrench
---

# Customization

## app/Config/AuthGroups.php

Create/add a multi-factor authentication group and assign it to users (or add the permission individually on a per-user basis). This permits creation of an opt-in system. The permission string should match the value in the *.env* file (default is *mfa.halberd*). Defining the permission string as an empty value will apply the module to all users.

```
public array $groups = [

	...

	'mfa' => [
		'title'       => 'Multi-Factor Authentication',
		'description' => 'Users that have opted into multi-factor authentication',
	],
];

public array $permissions = [

	...

	'mfa.halberd' => 'Enables the TOTP Halberd module',
];

public array $matrix = [

	...

	'mfa' => [
		'mfa.halberd',
	],
];
```

## Views

Create the following structure in your application to override the default view[^1]:

```
app/
	Views/
		overrides/
			GrimPirate/
				Halberd/
					Views/
						totp_2fa_show.php
```

[^1]: vendor/grimpirate/halberd/src/Views/totp_2fa_show.php