# `deleteScopedKey`

Revoke a domain-scoped key. Takes effect immediately.

**HTTP:** `DELETE /api/keys/scoped/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`ok-response` — see the [`ok-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteScopedKey('key_8Rt2NvQp');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
