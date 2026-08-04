# `rotateAppPassword`

Replace an app password's secret, keeping its scope. The old secret stops authenticating immediately; the new one is returned once. Use after a leak, when revoking would mean reconfiguring every client.

**HTTP:** `POST /api/app-passwords/{id}/rotate`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`app-password`

## Example

```php
$res = $mk->rotateAppPassword('apw_6Kd3PqR7');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
