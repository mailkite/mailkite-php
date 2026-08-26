# `stopSequence`

Stop whatever is chasing someone. Pass the `cancelKey` you set when starting — so you cancel with your own invoice or order id and never store ours — or pass `sequence` and `email` together when you did not set one. Always answers 200 with a count, so it is safe to fire blindly from a webhook.

**HTTP:** `POST /v1/sequences/stop`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `cancelKey` | string |  | The key you passed to startSequence. Stops every in-flight run carrying it. |
| `sequence` | string |  | Sequence name or id. Use with `email` when no cancelKey was set. |
| `email` | string |  | The contact to stop, used with `sequence`. |

## Returns

`stop-sequence-response` — see the [`stop-sequence-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->stopSequence([
    'cancelKey' => 'inv_1042',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
