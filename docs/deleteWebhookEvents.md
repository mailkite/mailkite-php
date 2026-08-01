# `deleteWebhookEvents`

Opt the domain's inbound webhook back out of engagement events (inbound email.received only — the default).

**HTTP:** `DELETE /api/domains/{id}/webhook-events`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`ok-response` — see the [`ok-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteWebhookEvents('dom_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
