# `getUsage`

Current billing-period usage: emails used vs the plan's included bucket (null = unlimited), AI actions, and the overage state that gates sending. Powers quota meters in dashboards and integrations.

**HTTP:** `GET /api/billing/usage`

## Parameters

_None._

## Returns

`usage-response` — see the [`usage-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->getUsage();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
