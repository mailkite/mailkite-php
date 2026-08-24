# `cancelEnrollmentsByKey`

Stop every in-flight enrollment carrying a `cancelKey` you set when enrolling — so you can cancel with your own invoice or order id instead of storing ours. Always answers 200 with a count, so it is safe to fire blindly from a webhook.

**HTTP:** `POST /v1/enrollments/cancel`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `cancelKey` | string | ✓ | The key you passed when enrolling. |

## Returns

`cancel-by-key-response` — see the [`cancel-by-key-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->cancelEnrollmentsByKey([
    'cancelKey' => 'invoice_9f2c',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
