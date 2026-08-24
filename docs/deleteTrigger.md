# `deleteTrigger`

Detach a trigger. Stops future enrollments through that door and nothing else.

**HTTP:** `DELETE /v1/triggers/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`delete-trigger-response` — see the [`delete-trigger-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteTrigger('trg_5f1c22ab');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
