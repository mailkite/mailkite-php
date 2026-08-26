# `cancelEnrollment`

Cancel one specific run by its enrollment id — the per-row action when you are looking at the enrollments table. To stop whatever is chasing a contact without knowing which run, use stopSequence.

**HTTP:** `DELETE /v1/enrollments/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`cancel-enrollment-response` — see the [`cancel-enrollment-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->cancelEnrollment('enr_5b2d9f01');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
