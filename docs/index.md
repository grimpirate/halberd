---
icon: lucide/info
---

# About

A TOTP (Time-Based One-Time Password) Two-Factor Authentication Module for [codeigniter4/shield](https://github.com/codeigniter4/shield).

* Generates a 32 byte secret key
* Generates a scannable QR Code that contains an *otpauth:* URL compatible with Google Authenticator[^1] App ([Android](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en_US)/[iOS](https://apps.apple.com/us/app/google-authenticator/id388497605)) for account registration/activation
* Authenticates a 6-digit, SHA1, 30-second period TOTP for login
* Prevents reuse of an TOTP within its validation period
* Implements Shield's ConditionalActionInterface to permit a per user configuration

[^1]: Google Authenticator implementation ignores: [Algorithm](https://github.com/google/google-authenticator/wiki/Key-Uri-Format#algorithm), [Digits](https://github.com/google/google-authenticator/wiki/Key-Uri-Format#digits), and [Period](https://github.com/google/google-authenticator/wiki/Key-Uri-Format#period) parameters of the *otpauth:* URL.
