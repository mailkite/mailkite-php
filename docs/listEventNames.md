# `listEventNames`

List the distinct event names this account works with, so an editor can offer them instead of asking you to remember one. Returns both events actually posted (with a count and when one last arrived) and events your sequences already trigger on or wait for but that may never have been sent — sequences are routinely written before the application emits the event, so a list of only-what-you-have-sent would be a trap.

**HTTP:** `GET /v1/events/names`

## Parameters

_None._

## Returns

`list-event-names-response` — see the [`list-event-names-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listEventNames();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
