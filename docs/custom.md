---
icon: lucide/wrench
---

# Customization

Create the following structure in your application to override the default view[^1] displayed by the Halberd module:

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