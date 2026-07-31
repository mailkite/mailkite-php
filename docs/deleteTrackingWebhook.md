# `deleteTrackingWebhook`

Remove the domain's tracking-event webhook (engagement events stop).

**HTTP:** `DELETE /api/domains/{id}/tracking-webhook`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`ok-response` — see the [`ok-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteTrackingWebhook('dom_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
