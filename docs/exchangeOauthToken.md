# `exchangeOauthToken`

Exchange an authorization code for an access token (or rotate a refresh token) — step 3 of linking. Between steps you send the user's browser to /oauth/authorize with your client_id, redirect_uri, state, and an S256 code_challenge; they sign in with whatever method they already use and approve, and the code comes back to your redirect_uri. Then call getApiKey with the access token and store the key.

**HTTP:** `POST /oauth/token`

## Parameters

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `grant_type` | string | ✓ | Which exchange to perform. |
| `code` | string |  | authorization_code grant: the single-use code from the redirect. Expires quickly and is… |
| `redirect_uri` | string |  | authorization_code grant: must match the redirect_uri used at /oauth/authorize exactly. |
| `client_id` | string |  | authorization_code grant: required. refresh_token grant: optional, but checked against… |
| `code_verifier` | string |  | authorization_code grant: the PKCE verifier whose S256 hash you sent as code_challenge… |
| `refresh_token` | string |  | refresh_token grant: the token to rotate. Single-use — the old one is revoked and a new… |

## Returns

`oauth-token-response` — see the [`oauth-token-response`](https://mailkite.dev/docs/api-reference) schema.

## Example

```php
$res = $mk->exchangeOauthToken([
    'grant_type' => 'authorization_code',
    'code' => 'mkc_4Tn8Wq2Vx7Rb',
    'redirect_uri' => 'https://myapp.ai/settings/mailkite/callback',
    'client_id' => 'mkcli_8Kq2Vn4TwXr7Bm3d',
    'code_verifier' => 'dBjftJeZ4CVPmB92K27uhbUJU1p1r0wsUPvhBLIm3ZY',
]);
```

---

[← All methods](../README.md#api-methods) · [Docs](https://mailkite.dev/docs) · [mailkite.dev](https://mailkite.dev)
