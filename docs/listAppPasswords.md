# `listAppPasswords`

List the account's app passwords. Each one opens a mailbox over IMAP and/or the mailbox API, scoped to a domain and an address pattern within it.

**HTTP:** `GET /api/app-passwords`

## Parameters

_None._

## Returns

`app-password[]`

## Example

```php
$res = $mk->listAppPasswords();
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
