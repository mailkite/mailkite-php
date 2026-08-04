# `getMailboxMessageRaw`

Fetch one message's raw RFC822 bytes from a mailbox. Same app password auth as the list.

**HTTP:** `GET /api/mailbox/messages/{uid}/raw`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `uid` | path | — |
| `address` | query | — |

## Returns

`string`

## Example

```php
$res = $mk->getMailboxMessageRaw(42, 'support-billing@acme.dev');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
