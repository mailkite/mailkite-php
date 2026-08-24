# `listTriggers`

List the triggers attached to a sequence — the doors into it.

**HTTP:** `GET /v1/sequences/{id}/triggers`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`list-triggers-response` — see the [`list-triggers-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listTriggers('seq_3c8f21aa');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
