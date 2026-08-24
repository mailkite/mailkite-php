# `createSequence`

Create a sequence: a trigger plus the steps a contact walks over time. Created as a draft unless you pass status "active" — a sequence enrolls nobody until it is active. The whole definition is validated up front and every problem is reported at once, so you fix a program in one pass rather than one 400 at a time.

**HTTP:** `POST /v1/sequences`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | ✓ | Unique handle for this account; 1-64 chars of letters, digits, dot, dash, or underscore… |
| `status` | string |  | Defaults to `draft`. A sequence enrolls nobody until it is `active`. |
| `from` | string |  | Default sender for every send step, on a verified domain. Required unless every send step… |
| `trigger` | any | ✓ |  |
| `steps` | array | ✓ | At least one step, and at least one of them a `send` — a sequence that never sends is a… |
| `reentry` | string |  | `once` (default) refuses to enroll a contact already in flight. `always` restarts them… |
| `exitOn` | object,null |  | Sequence-level exits, evaluated before EVERY step. `goal` completes the enrollment — they… |

## Returns

`sequence-response` — see the [`sequence-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->createSequence([
    'name' => 'dunning',
    'status' => 'active',
    'from' => 'billing@acme.dev',
    'trigger' => ['type' => 'send'],
    'steps' => [['type' => 'delay', 'for' => '3 days'], ['type' => 'send', 'templateId' => 'tpl_8Rt5NmZx', 'subject' => 'Your invoice is still unpaid']],
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
