---
icon: lucide/wrench
---

# Customization

Override the view[^1] displayed by the Halberd module by creating the following structure in your application:

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