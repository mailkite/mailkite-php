# `startSequence`

Start a sequence for one contact, directly — when your code already knows WHICH sequence it wants. Takes a sequence NAME or id, so "start the dunning sequence" needs no lookup. Returns the enrollment it created: the run you then inspect, follow, or cancel. Refused with 409 when the address is suppressed, is already running on a `reentry: "once"` sequence, or is missing a required input — and the response says which. Reach for sendEvent instead when your code only knows what HAPPENED and policy should decide what reacts.

**HTTP:** `POST /v1/sequences/{sequence}/start`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `email` | string |  | The address to enroll. Give this or `contactId`. |
| `contactId` | string |  | A contact you own (ctc_…), as an alternative to `email`. |
| `from` | string |  | Sender for this enrollment, when the sequence has no default (a send-triggered sequence… |
| `input` | object |  | The sequence's input, checked against its declared signature. A missing required field… |
| `cancelKey` | string |  | Your own key for this enrollment. Cancel later with POST /v1/enrollments/cancel and this… |

## Returns

`enrollment-response` — see the [`enrollment-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->startSequence([
    'sequence' => 'dunning',
    'email' => 'ada@example.com',
    'input' => ['invoiceId' => 'inv_1042'],
    'cancelKey' => 'inv_1042',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
