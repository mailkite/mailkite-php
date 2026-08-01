# `setWebhookEvents`

Opt the domain's inbound webhook into engagement events — one webhook, all events. Pass "all" or a list of email.* tracking types (email.sent / email.bounced / email.complained / email.opened / email.clicked) and MailKite delivers them to the same webhook route that receives the domain's inbound mail; consumers switch on the payload's `type` (inbound mail is type email.received, engagement events follow the tracking-event schema). Off by default, so existing inbound consumers never see event types they didn't opt into. Events at the inbound webhook are signed with that route's secret (account secret fallback) — the same key inbound deliveries already use. If a dedicated tracking webhook URL is set (setTrackingWebhook), engagement events go there instead.

**HTTP:** `PUT /api/domains/{id}/webhook-events`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `events` | string \| array | ✓ | Which email.* engagement events the domain's inbound webhook also receives: the literal… |

## Returns

`set-webhook-events-response` — see the [`set-webhook-events-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->setWebhookEvents([
    'id' => 'dom_1',
    'events' => ['email.bounced', 'email.complained'],
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
