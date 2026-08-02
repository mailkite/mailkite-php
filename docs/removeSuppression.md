# `removeSuppression`

Remove an address from the suppression list (URL-encode the email in the path). Removing an unsuppressed address is a no-op success.

**HTTP:** `DELETE /api/contacts/suppressions/{email}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `email` | path | — |

## Returns

`remove-suppression-response` — see the [`remove-suppression-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->removeSuppression('unsubscribed@example.com');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
