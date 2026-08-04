# `claimSubdomain`

Claim a free MailKite subdomain — a `<label>.<base>` host on a zone we run (call suggestSubdomain for the current `base`; the pool changes over time and more than one may be offered). The fastest path to a sending identity: we host the zone, so it comes back already verified with an empty `dns` array — nothing for the customer to publish. Use it when you want onboarding to work without asking anyone to touch DNS; bring your own domain with createDomain when you want mail to come from your own name.

**HTTP:** `POST /api/domains/subdomain`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `subdomain` | string | ✓ | The label to claim: 3–32 characters, lowercase letters, digits and hyphens, no leading or… |

## Returns

`claim-subdomain-response` — see the [`claim-subdomain-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->claimSubdomain([
    'subdomain' => 'swift-otter',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
