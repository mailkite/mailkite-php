# `getWebhookSecret`

Get this domain's webhook signing secret (whsec_…) — the per-route secret used to verify x-mailkite-signature on its inbound deliveries. Server-side only (SDK/REST); never exposed to MCP or browser client libraries.

**HTTP:** `GET /api/domains/{id}/webhook/secret`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`any`

## Example

```php
$res = $mk->getWebhookSecret('dom_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
