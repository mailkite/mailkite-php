# `getEnrollment`

Get one enrollment — which sequence, which step, and what happens next.

**HTTP:** `GET /v1/enrollments/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`enrollment-response` — see the [`enrollment-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->getEnrollment('enr_5b2d9f01');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
