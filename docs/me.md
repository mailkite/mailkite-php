# `me`

The account behind this credential: email, whether it is verified (sending is blocked until it is), and plan. Use to poll verification state after register().

**HTTP:** `GET /v1/me`

## Parameters

_None._

## Returns

`me-response` — see the [`me-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->me();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
