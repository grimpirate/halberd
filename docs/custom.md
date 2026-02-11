---
icon: lucide/wrench
---

# Customization

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