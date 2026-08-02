# `createScopedKey`

Create a key scoped to one domain. Ideal for per-site installs (e.g. a WordPress plugin) — the site never holds the account master key.

**HTTP:** `POST /api/keys/scoped`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `domainId` | string | ✓ | The domain (dom_…) the new key is limited to. Must belong to the calling account. |
| `name` | string |  | Optional label shown in the dashboard (e.g. which site/integration holds this key). |

## Returns

`scoped-key`

## Example

```php
$res = $mk->createScopedKey([
    'domainId' => 'dom_2VbXqTpN8rKw',
    'name' => 'blog-wordpress',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
