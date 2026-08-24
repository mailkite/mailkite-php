# `sendEvent`

Record one application-level fact about a user — `user.created`, `trial.expiring`, `payment.failed`. THE primary way a sequence starts on a developer platform: your application already knows when a payment failed, so it says so, and every enabled trigger listening for that name enrolls the contact with the payload as its input. Identify the subject with `email` or `contactId` (never both). Pass a `dedupeKey` to make retries idempotent: a repeat returns the original event with `duplicate: true` rather than enrolling anyone twice.

**HTTP:** `POST /v1/events`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | ✓ | Event name: 1-64 characters of letters, digits, dot, dash, or underscore, starting… |
| `event` | string |  | Alias for `name`, accepted so a payload written for another provider works unchanged… |
| `email` | string |  | The address this event is about. Give either this or `contactId`, never both. An address… |
| `contactId` | string |  | A contact you own (ctc_…), as an alternative to `email`. Give either this or `email`… |
| `payload` | object |  | Free-form context carried with the event. Sequence steps read it as {{event.*}} for merge… |
| `dedupeKey` | string |  | Idempotency key. A second POST with the same key returns the ORIGINAL event and… |

## Returns

`send-event-response` — see the [`send-event-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->sendEvent([
    'name' => 'trial.expiring',
    'email' => 'ada@example.com',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
