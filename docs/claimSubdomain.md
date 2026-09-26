# `claimSubdomain`

Claim a free MailKite subdomain — a `<label>.<base>` host on a zone we run (call suggestSubdomain for the current `base`; the pool changes over time and more than one may be offered). We publish its DNS automatically and return an empty `dns` array — nothing for the customer to publish. New claims start on SES and may remain pending while SES verifies DKIM; call verifyDomain until verified before sending. Bring your own domain with createDomain when you want mail to come from your own name.

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
