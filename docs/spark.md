---
icon: lucide/terminal
---

# Commands

## halberd:totp

Allows an administrator to regenerate a user's *totp_2fa* authentication identity.

``` bash title=">_"
php spark halberd:totp <id>
```

!!! note

	The user's account will be deactivated so that on subsequent login they can rescan the new QR Code into their authenticator app.

## halberd:tidy

Cleans up the grimpirate/halberd vendor repository to remove all but the needed source files.

``` bash title=">_"
php spark halberd:tidy
```