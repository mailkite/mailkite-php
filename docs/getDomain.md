# `getDomain`

Get one domain with DNS records + webhook.

**HTTP:** `GET /api/domains/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`get-domain-response` — see the [`get-domain-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->getDomain('dom_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
