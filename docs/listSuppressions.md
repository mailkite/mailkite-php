# `listSuppressions`

List suppressed addresses (unsubscribes, hard bounces, spam complaints, manual). Sends to a suppressed address are dropped before delivery.

**HTTP:** `GET /api/contacts/suppressions`

## Parameters

_None._

## Returns

`suppressions-response` — see the [`suppressions-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listSuppressions();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
