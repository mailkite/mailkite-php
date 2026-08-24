# `deleteSequence`

Delete a sequence and retire every contact still walking it. The response reports how many were canceled.

**HTTP:** `DELETE /v1/sequences/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`delete-sequence-response` — see the [`delete-sequence-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteSequence('seq_3c8f21aa');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
