# `sendBatch`

Send one personalized message per recipient (up to 50) in a single call. Shared fields form the base message; each `recipients[]` entry gets its own message to exactly one address, with per-recipient `templateData` and `headers` merged over the shared ones. Every message passes the same gates as send() and gets its own id; the response reports each recipient's outcome in order, so a batch can partially succeed. Pass `scheduledAt` to park the whole batch for later (one cancelable ssnd_… per recipient).

**HTTP:** `POST /v1/send/batch`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `from` | string | ✓ | An address on a verified domain. Shared by every message in the batch. |
| `recipients` | array | ✓ | One entry per message. Order is preserved in the response's results[]. |
| `subject` | string |  | Required unless supplied by a template. May contain {{merge_tags}}, filled per recipient. |
| `html` | string |  | May contain {{merge_tags}}, filled per recipient. |
| `text` | string |  | May contain {{merge_tags}}, filled per recipient. |
| `templateId` | string |  | Send using a saved template — a user template (tpl_…) or a base template (base_…). Its… |
| `templateData` | object |  | Shared default merge values for every recipient; a recipient's own templateData overrides… |
| `headers` | object |  | Shared extra raw MIME headers for every message, applied after threading headers (caller… |
| `replyTo` | string |  |  |
| `inReplyTo` | string |  | Thread every message under this Message-ID. |
| `attachments` | array |  | Attached to every message in the batch. Same shape as send()'s attachments. |
| `scheduledAt` | string,number |  | Send later: ISO 8601, simple relative natural language ("in 2 hours"), or a ms-epoch. A… |
| `trackOpens` | boolean |  | Open-tracking override for every message in the batch (HTML only). Omitted → the… |
| `trackClicks` | boolean |  | Click-tracking override for every message in the batch (HTML only): http(s) links are… |

## Returns

`batch-send-response` — see the [`batch-send-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->sendBatch([
    'from' => 'hello@app.mailkite.dev',
    'subject' => 'Your {{plan}} invoice',
    'html' => '<p>Hi {{name}}, your {{plan}} invoice is attached.</p>',
    'templateData' => ['plan' => 'Pro'],
    'recipients' => [['to' => 'Ada Lovelace <ada@example.com>', 'templateData' => ['name' => 'Ada']], ['to' => 'grace@example.com', 'templateData' => ['name' => 'Grace', 'plan' => 'Team'], 'headers' => ['X-Entity-Ref-ID' => 'inv-1043']]],
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
