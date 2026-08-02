# `listScopedKeys`

List the account's domain-scoped API keys. A scoped key can send and manage only its one domain — hand one to each site or CI job so a leak burns only that surface.

**HTTP:** `GET /api/keys/scoped`

## Parameters

_None._

## Returns

`scoped-key[]`

## Example

```php
$res = $mk->listScopedKeys();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
