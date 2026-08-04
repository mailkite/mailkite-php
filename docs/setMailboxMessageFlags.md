# `setMailboxMessageFlags`

Replace a message's IMAP flags (e.g. mark it `Seen`). Flags set here are the same ones an IMAP client sees.

**HTTP:** `POST /api/mailbox/messages/{uid}/flags`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `flags` | string | ✓ | The complete flag set to store, space-separated and WITHOUT leading backslashes (e.g… |

## Returns

`ok-response` — see the [`ok-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->setMailboxMessageFlags([
    'uid' => 42,
    'address' => 'support-billing@acme.dev',
    'flags' => 'Seen',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
