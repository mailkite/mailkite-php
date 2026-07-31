# `removeListContact`

Remove one contact from a list (the contact itself is kept).

**HTTP:** `DELETE /api/lists/{id}/contacts/{contactId}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |
| `contactId` | path | — |

## Returns

`ok-response` — see the [`ok-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->removeListContact('lst_1', 'ctr_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
