# `suggestSubdomain`

Suggest a free, currently-unclaimed subdomain label to prefill the input with, plus the `base` zone it would live on. Read-only — suggesting does not reserve the name. Always take the zone from `base` rather than hard-coding it: which zones are on offer changes over time.

**HTTP:** `GET /api/domains/subdomain/suggest`

## Parameters

_None._

## Returns

`subdomain-suggestion`

## Example

```php
$res = $mk->suggestSubdomain();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
