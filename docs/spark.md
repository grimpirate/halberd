---
icon: lucide/terminal
---

# Commands

## halberd:totp

Allows an administrator to ==overwrite== a user's current *totp_2fa* authentication identity with a new secret.

``` bash title=">_"
php spark halberd:totp <id>
```

!!! note

	The user's account will be deactivated so that on subsequent login they can rescan the new QR Code into their authenticator app.