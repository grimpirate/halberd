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

Cleans up the grimpirate/halberd vendor repository.  This will reduce the vendor folder size by removing unneeded files from the package install.

``` bash title=">_"
php spark halberd:tidy

```
