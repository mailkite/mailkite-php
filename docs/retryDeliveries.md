# `retryDeliveries`

Replay a whole selection of webhook deliveries in one call — the bulk form of retryDelivery. Pass `deliveryIds` (replay those exact deliveries), `messageIds` (replay each message's most recent delivery per route), and/or `threadIds` (expanded server-side to every message in the conversation); they combine. At most 50 ids per request, so send larger selections as sequential batches. Always answers 200 with a per-id `results` array — one unreachable endpoint never hides the outcomes of the rest — so branch on `ok` and `results`, not the HTTP status. An id you don't own is reported as skipped with reason `not_found`, exactly as the single-delivery endpoint 404s.

**HTTP:** `POST /api/deliveries/retry`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `deliveryIds` | array |  | Replay exactly these delivery rows (dlv_…), to the URL each recorded. |
| `messageIds` | array |  | For each message (msg_…), replay its most recent delivery per route. A message no webhook… |
| `threadIds` | array |  | Conversation ids — expanded server-side to every message in the thread, then treated as… |

## Returns

`replay-response` — see the [`replay-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->retryDeliveries([
    'deliveryIds' => ['dlv_1', 'dlv_2', 'dlv_gone'],
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
