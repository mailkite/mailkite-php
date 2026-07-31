# `checkDomainAvailability`

Check whether a domain is available to register, and at what price. Read-only — no charge.

**HTTP:** `GET /api/domains/register/check`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `domain` | query | — |

## Returns

`domain-availability-response` — see the [`domain-availability-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->checkDomainAvailability('acme.com');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
