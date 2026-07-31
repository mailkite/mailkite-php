# `verifyDomain`

Check DNS and update status.

**HTTP:** `POST /api/domains/{id}/verify`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`verify-domain-response` — see the [`verify-domain-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->verifyDomain('dom_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
