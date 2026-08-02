# `getApiKey`

Get the account's unrestricted API key (mk_live_…). Read-or-create: the first call mints it.

**HTTP:** `GET /api/keys`

## Parameters

_None._

## Returns

`api-key-response` — see the [`api-key-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->getApiKey();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
