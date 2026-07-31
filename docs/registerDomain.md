# `registerDomain`

Register (buy) a domain on the customer's behalf; provisions mail DNS and adds it to the account in one call. Charges the registrar.

**HTTP:** `POST /api/domains/register`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `domain` | string | ✓ |  |
| `contact` | object | ✓ |  |
| `years` | integer |  |  |
| `dryRun` | boolean |  |  |

## Returns

`register-domain-response` — see the [`register-domain-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->registerDomain([
    'domain' => 'acme.com',
    'contact' => ['firstName' => 'Jane', 'lastName' => 'Doe', 'email' => 'jane@example.com', 'phone' => '+1.4155551234', 'address' => '123 Main St', 'city' => 'SF', 'zip' => '94016', 'country' => 'US'],
    'years' => 1,
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
