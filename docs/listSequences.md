# `listSequences`

List your sequences, newest first, each with live enrollment counts. Archived sequences are omitted.

**HTTP:** `GET /v1/sequences`

## Parameters

_None._

## Returns

`list-sequences-response` — see the [`list-sequences-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listSequences();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
