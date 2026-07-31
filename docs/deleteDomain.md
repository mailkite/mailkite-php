# `deleteDomain`

Remove a domain.

**HTTP:** `DELETE /api/domains/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`delete-domain-response` — see the [`delete-domain-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteDomain('dom_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
