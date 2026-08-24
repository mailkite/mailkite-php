# `enrollContact`

Put one contact into an active sequence by hand. Refused with 409 when the address is suppressed, or already in flight on a `reentry: "once"` sequence. Pass `cancelKey` to be able to cancel later using your own identifier.

**HTTP:** `POST /v1/sequences/{id}/enroll`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `email` | string |  | The address to enroll. Give this or `contactId`. |
| `contactId` | string |  | A contact you own (ctc_…), as an alternative to `email`. |
| `from` | string |  | Sender for this enrollment, when the sequence has no default (a send-triggered sequence… |
| `data` | object |  | Context carried with the enrollment and readable in merge tags as {{event.*}}. |
| `cancelKey` | string |  | Your own key for this enrollment. Cancel later with POST /v1/enrollments/cancel and this… |

## Returns

`enrollment-response` — see the [`enrollment-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->enrollContact([
    'id' => 'seq_3c8f21aa',
    'email' => 'ada@example.com',
    'cancelKey' => 'invoice_9f2c',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
