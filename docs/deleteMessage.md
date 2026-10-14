# `deleteMessage`

Soft-delete one stored message owned by your account. Hides it from normal message, conversation and mailbox reads while retaining content, attachments and delivery evidence. Does not recall delivered mail or reduce metered usage. Repeated deletion returns the original deleted_at timestamp; unknown or foreign ids return 404.

**HTTP:** `DELETE /api/messages/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`delete-message-response` — see the [`delete-message-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteMessage('msg_bench');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
