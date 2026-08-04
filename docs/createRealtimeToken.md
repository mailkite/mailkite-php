# `createRealtimeToken`

Mint a short-lived, single-use token that authorises one Realtime API connection. For browsers: EventSource cannot set headers, so this is what a page passes as ?token= instead of putting an API key in a URL. Inherits the calling credential's scope, expires in five minutes, and burns on first use. The stream itself is GET /v1/realtime — a subscription, not a request/response call, so it is contracted in sdks/spec/realtime.json rather than here.

**HTTP:** `POST /v1/realtime/token`

## Parameters

_None._

## Returns

`realtime-token-response` — see the [`realtime-token-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->createRealtimeToken();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
