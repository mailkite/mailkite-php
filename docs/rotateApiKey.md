# `rotateApiKey`

Rotate the account API key: the old key stops working immediately and a fresh one is returned. The plaintext is only shown here.

**HTTP:** `POST /api/keys/rotate`

## Parameters

_None._

## Returns

`api-key-response` — see the [`api-key-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->rotateApiKey();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
