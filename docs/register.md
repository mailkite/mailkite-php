# `register`

Create a MailKite account from just an email — no password. Returns the new account's API key immediately; a verification link is emailed, and SENDING stays blocked until the address is verified (poll me()). An existing email returns 409 account_exists with no credentials. Powers plugin/CLI onboarding.

**HTTP:** `POST /api/v1/provision`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `email` | string | ✓ | The account email. A verification link is sent to it — the account cannot send email… |
| `channel` | string |  | Distribution-channel slug this registration came through (e.g. wordpress-plugin). Invalid… |
| `ref` | string |  | Referral code of the account that referred this signup, when any. |
| `referrer` | string |  | First-touch landing referrer URL, when known. Invalid values are dropped, never an error. |

## Returns

`register-response` — see the [`register-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->register([
    'email' => 'owner@myapp.ai',
    'channel' => 'wordpress-plugin',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
