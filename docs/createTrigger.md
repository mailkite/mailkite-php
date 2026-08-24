# `createTrigger`

Attach a trigger: when this event arrives, enroll the contact it is about. Attaching never bumps the sequence's version and never touches anyone already in flight — a trigger is a fact about the outside world, a sequence is a program, and they change on different rhythms. The sequence needs a `from` address first, since an event-triggered enrollment has no message to inherit a sender from.

**HTTP:** `POST /v1/sequences/{id}/triggers`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `event` | string | ✓ |  |
| `filter` | any |  |  |
| `enabled` | boolean |  | Defaults to true. |

## Returns

`trigger-response` — see the [`trigger-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->createTrigger([
    'id' => 'seq_3c8f21aa',
    'event' => 'payment.failed',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
