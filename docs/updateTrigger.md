# `updateTrigger`

Edit a trigger, or toggle `enabled` to switch the door off without deleting it. Either way, everyone already walking the sequence carries on.

**HTTP:** `PATCH /v1/triggers/{id}`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `event` | string |  |  |
| `filter` | any |  |  |
| `enabled` | boolean |  |  |

## Returns

`trigger-response` — see the [`trigger-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->updateTrigger([
    'id' => 'trg_5f1c22ab',
    'enabled' => false,
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
