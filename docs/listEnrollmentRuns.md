# `listEnrollmentRuns`

Every step this enrollment has executed, with the outcome and the reason for it. This is the "why didn't step 3 fire" view.

**HTTP:** `GET /v1/enrollments/{id}/runs`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`list-runs-response` — see the [`list-runs-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listEnrollmentRuns('enr_5b2d9f01');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
