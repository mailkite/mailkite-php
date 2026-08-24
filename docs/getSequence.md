# `getSequence`

Get one sequence with its definition and live enrollment counts.

**HTTP:** `GET /v1/sequences/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`sequence-response` — see the [`sequence-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->getSequence('seq_3c8f21aa');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
