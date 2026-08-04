# `listMailboxMessages`

List a mailbox's messages, newest first. Authenticated with an app password granting `api` — this is how an agent reads its own inbox without an IMAP client.

**HTTP:** `GET /api/mailbox/messages`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `address` | query | — |
| `before` | query (optional) | Cursor: return only messages with a UID strictly less than this. Omit for the first page. |
| `limit` | query (optional) | Max messages to return, 1–200. Omitted = 50. |

## Returns

`mailbox-messages-response` — see the [`mailbox-messages-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listMailboxMessages('support-billing@acme.dev');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
