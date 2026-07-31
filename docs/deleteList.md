# `deleteList`

Delete a contact list. The list is removed; the contacts themselves are kept.

**HTTP:** `DELETE /api/lists/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`ok-response` — see the [`ok-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteList('lst_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
