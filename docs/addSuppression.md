# `addSuppression`

Suppress an address so this account never sends to it again (reason defaults to manual).

**HTTP:** `POST /api/contacts/suppressions`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `email` | string | ✓ | The address to stop sending to. |
| `reason` | string |  | Why — defaults to manual when omitted or unrecognized. |
| `note` | string |  | Optional free-text note (who/why), shown alongside the entry. |

## Returns

`add-suppression-response` — see the [`add-suppression-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->addSuppression([
    'email' => 'unsubscribed@example.com',
    'reason' => 'unsubscribe',
    'note' => 'customer asked via support ticket #482',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
