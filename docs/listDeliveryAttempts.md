# `listDeliveryAttempts`

Every captured attempt for one delivery, newest first: the request headers and payload we POSTed, and the status, headers, and body that came back. This is the per-attempt record behind a webhook post-mortem, fetched without pulling the whole message. Captures are retained for 45 days.

**HTTP:** `GET /api/deliveries/{id}/attempts`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`delivery-attempts-response` — see the [`delivery-attempts-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listDeliveryAttempts('dlv_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
