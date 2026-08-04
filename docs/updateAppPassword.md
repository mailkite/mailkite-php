# `updateAppPassword`

Change what an app password covers — its label, address pattern, or protocols. The domain is fixed for the life of the password: repointing a live credential would hand its holder mail they were never granted, so create a new password instead.

**HTTP:** `PATCH /api/app-passwords/{id}`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `address` | string |  | New local-part pattern — `*` (every address), `hello`, `support-*`, `*-agent`. No `@`… |
| `protocols` | array |  | Replaces the existing set. Must be a non-empty subset of `["imap","api"]`. |
| `label` | string |  | New name shown in the dashboard. |

## Returns

`app-password`

## Example

```php
$res = $mk->updateAppPassword([
    'id' => 'apw_6Kd3PqR7',
    'address' => 'triage-*',
    'protocols' => ['imap', 'api'],
    'label' => 'triage bot',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
