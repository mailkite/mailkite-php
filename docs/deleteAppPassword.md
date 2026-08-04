# `deleteAppPassword`

Revoke an app password. Takes effect immediately — any IMAP session or API call using it stops authenticating.

**HTTP:** `DELETE /api/app-passwords/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`ok-response` — see the [`ok-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteAppPassword('apw_6Kd3PqR7');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
