# `deliverToRoute`

POST stored messages to one webhook route — including messages that arrived BEFORE the route existed, which no retry can reach (a retry replays an existing delivery row, and a new route has none). Use listRouteCandidates to find what a route could be sent. Webhook routes only: a forward would re-send real mail to a third party and an agent would re-spend model tokens, so both answer 400 `route_action`. At most 50 ids per request; same per-id `results` contract as retryDeliveries.

**HTTP:** `POST /api/routes/{id}/deliver`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `messageIds` | array | ✓ | Stored messages (msg_…) to deliver to this route's webhook, in any order. |

## Returns

`replay-response` — see the [`replay-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deliverToRoute([
    'id' => 'rte_1',
    'messageIds' => ['msg_2Hk9QpVn4tLd', 'msg_5Tq1RvXz'],
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
