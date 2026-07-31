# `setTrackingWebhook`

Set or replace the domain's outbound tracking-event webhook: an HTTPS endpoint that receives signed email.* engagement events (email.sent / email.bounced / email.complained / email.opened / email.clicked, shaped per the tracking-event schema). A separate URL from the inbound-mail webhook, so inbound consumers never see event types they don't expect. Returns the signing secret (the same account secret as inbound deliveries).

**HTTP:** `PUT /api/domains/{id}/tracking-webhook`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `url` | string | ✓ | HTTPS endpoint to receive signed email.* engagement events… |

## Returns

`set-tracking-webhook-response` — see the [`set-tracking-webhook-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->setTrackingWebhook([
    'id' => 'dom_1',
    'url' => 'https://app.com/hooks/mailkite-events',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
