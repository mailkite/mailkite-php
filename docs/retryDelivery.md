# `retryDelivery`

Re-deliver a stored message to its webhook.

**HTTP:** `POST /api/deliveries/{id}/retry`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`retry-delivery-response` — see the [`retry-delivery-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->retryDelivery('dlv_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
