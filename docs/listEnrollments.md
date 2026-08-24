# `listEnrollments`

List who is in a sequence and where each of them is. Filter with `status`.

**HTTP:** `GET /v1/sequences/{id}/enrollments`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |
| `status` | query (optional) | Only enrollments in this state: active, waiting, completed, canceled, or failed. |
| `limit` | query (optional) | Max rows, 1-500. Omitted = 100. |

## Returns

`list-enrollments-response` — see the [`list-enrollments-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listEnrollments('seq_3c8f21aa');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
