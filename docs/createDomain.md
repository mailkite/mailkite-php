# `createDomain`

Add a domain. Returns the domain + DNS records. Paid plans may pass `email_provider_id` to choose a provider (list available providers with listEmailProviders); free plans are always pinned to the platform default (SES US East 2 production).

**HTTP:** `POST /api/domains`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `domain` | string | ✓ |  |

## Returns

`create-domain-response` — see the [`create-domain-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->createDomain([
    'domain' => 'app.mailkite.dev',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
