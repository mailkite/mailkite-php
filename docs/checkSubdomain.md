# `checkSubdomain`

Check whether a free subdomain label can be claimed. Read-only and cheap — call it as the user types. `reason` explains a rejection and is safe to show verbatim.

**HTTP:** `GET /api/domains/subdomain/check`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `name` | query | — |

## Returns

`subdomain-availability`

## Example

```php
$res = $mk->checkSubdomain('swift-otter');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
