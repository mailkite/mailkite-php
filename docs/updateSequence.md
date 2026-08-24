# `updateSequence`

Edit a sequence. Changing the STEPS bumps its version and contacts already in flight keep walking the version they started on, so an edit can never make someone skip or repeat a step. Nothing else re-pins anybody — a rename, a pause, the input signature, and the trigger set are all editable while people are mid-flight. Archiving retires everyone in flight; pausing deliberately does not, so unpausing resumes rather than restarts.

**HTTP:** `PATCH /v1/sequences/{id}`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string |  |  |
| `status` | string |  |  |
| `from` | string |  |  |
| `input` | object,null |  | The sequence's input signature: the shape every door must supply. A sequence is a… |
| `triggers` | array |  | Doors into this sequence. A bare string is shorthand for { "event": "<name>" }. Replacing… |
| `steps` | array |  |  |
| `reentry` | string |  | `once` (default) refuses to enroll a contact already in flight. `always` restarts them… |
| `exitOn` | object,null |  | Sequence-level exits, evaluated before EVERY step. `goal` completes the enrollment — they… |

## Returns

`sequence-response` — see the [`sequence-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->updateSequence([
    'id' => 'seq_3c8f21aa',
    'status' => 'paused',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
