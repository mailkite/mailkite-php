# `deleteRoute`

Delete an inbound routing rule by id. Pair with createRoute to register and tear down a webhook destination — e.g. an automation platform subscribing on enable and cleaning up on disable.

**HTTP:** `DELETE /api/routes/{id}`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |

## Returns

`ok-response` — see the [`ok-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->deleteRoute('rte_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
