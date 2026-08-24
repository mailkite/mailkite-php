# `listEvents`

List recorded events, newest first — the surface for confirming a POST landed and for debugging a sequence that did not trigger. Filter by `name` and/or `email`.

**HTTP:** `GET /v1/events`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `name` | query (optional) | Return only events with this exact name. Omit for all names. |
| `email` | query (optional) | Return only events about this address (case-insensitive). Omit for all contacts. |
| `limit` | query (optional) | Max rows to return, 1-200. Omitted = newest 50. |

## Returns

`list-events-response` — see the [`list-events-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listEvents();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
