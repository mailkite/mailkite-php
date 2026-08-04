# `createAppPassword`

Create an app password for one domain and address pattern. Hand it to a mail client or an agent — the secret is returned once and never again.

**HTTP:** `POST /api/app-passwords`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `domain` | string | ✓ | The hosted domain this password covers. Must belong to the calling account. |
| `domainId` | string |  | The domain by id (dom_…), as an alternative to `domain`. |
| `address` | string |  | Local-part pattern within the domain — `*` (default, every address), `hello`… |
| `protocols` | array |  | What the password may authenticate. Defaults to `["imap"]`. |
| `label` | string |  | Optional name shown in the dashboard (e.g. the client or agent holding it). |

## Returns

`app-password`

## Example

```php
$res = $mk->createAppPassword([
    'domain' => 'acme.dev',
    'address' => 'support-*',
    'protocols' => ['imap', 'api'],
    'label' => 'support inbox agent',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
