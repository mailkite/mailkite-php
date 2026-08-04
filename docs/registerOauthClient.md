# `registerOauthClient`

Register an OAuth client for this installation (RFC 7591 dynamic client registration) — step 1 of linking an existing MailKite account to your app. No pre-shared secret and no manual app review: you get a client_id back immediately and prove yourself with PKCE. Register once per install and keep the client_id.

**HTTP:** `POST /oauth/register`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `redirect_uris` | array | ✓ | Where the authorization code is delivered. Every entry must be an absolute https URL —… |
| `client_name` | string |  | Human-readable name shown to the user on the consent screen. Include the site or install… |

## Returns

`oauth-client-response` — see the [`oauth-client-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->registerOauthClient([
    'client_name' => 'MailKite for myapp.ai',
    'redirect_uris' => ['https://myapp.ai/settings/mailkite/callback'],
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
