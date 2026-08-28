# `listRouteCandidates`

Stored inbound messages this route could be asked to deliver, newest first — the preview for replaying mail to a route defined after that mail arrived. Each row carries `delivered_here`, so you can send a route only what it has never seen. Page with `before` (the response's `nextBefore`); because matching happens after a bounded scan, a page can come back shorter than `limit` while more still remain — keep going until `nextBefore` is null.

**HTTP:** `GET /api/routes/{id}/candidates`

## Parameters

| Name | In | Description |
| --- | --- | --- |
| `id` | path | — |
| `before` | query (optional) | Cursor: scan only messages with `received_at` strictly less than this (epoch ms). Pass the previous… |
| `limit` | query (optional) | Max matching rows to return, 1–100. Omitted = 50. |

## Returns

`route-candidates-response` — see the [`route-candidates-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->listRouteCandidates('rte_1');
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
