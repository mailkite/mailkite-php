<p align="center">
  <a href="https://mailkite.dev">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://mailkite.dev/brand/logo-email-dark.png">
      <img src="https://mailkite.dev/brand/logo-email.png" alt="MailKite" height="56">
    </picture>
  </a>
</p>

<h1 align="center">MailKite for PHP</h1>

<p align="center">
  <b>Email for every product you ship</b> — receive email as a webhook, send over a verified domain, give an AI agent its own inbox.
  <br>The official <a href="https://mailkite.dev">MailKite</a> library for PHP.
</p>

<p align="center">
  <a href="https://mailkite.dev/docs">Docs</a> ·
  <a href="https://mailkite.dev/docs/libraries">Library guide</a> ·
  <a href="https://mailkite.dev">mailkite.dev</a> ·
  <a href="https://mailkite.dev/docs/ai-agents">AI agents</a>
</p>
<p align="center"><a href="https://packagist.org/packages/mailkite/mailkite"><img src="https://img.shields.io/packagist/v/mailkite/mailkite?color=2563eb&label=Packagist" alt="Packagist"></a></p>

> **Read-only mirror.** This repo is a generated, release-time mirror of the MailKite monorepo (the private source of truth) — development doesn't happen here. Install from Packagist and open issues against the [MailKite docs](https://mailkite.dev/docs).

## Install

```bash
composer require mailkite/mailkite
```

## Quickstart

```php
<?php
require 'vendor/autoload.php';

$mk = new \MailKite\Client(getenv('MAILKITE_API_KEY'));

$res = $mk->send([
    'from' => 'hello@myapp.ai',
    'to' => 'ada@example.com',
    'subject' => 'Your invoice #1042',
    'html' => '<p>Thanks! Receipt attached.</p>',
]);
```

## Examples

Runnable examples live in [`examples/`](examples/) — send mail, verify webhooks, build an AI email agent, and log users in:

| Example | What it shows |
| --- | --- |
| [`examples/01-send-email.php`](examples/01-send-email.php) | Send an email over a verified domain — the 10-second "it works". |
| [`examples/02-receive-webhook.php`](examples/02-receive-webhook.php) | Receive inbound email as a webhook — and VERIFY the HMAC signature before trusting it. |
| [`examples/03-agent-reply.php`](examples/03-agent-reply.php) | An AI email agent: inbound email → Claude drafts a reply → MailKite sends it, threaded. |
| [`examples/04-agent-inbox.php`](examples/04-agent-inbox.php) | Give your agent its own email address — MailKite's built-in inbox agent answers mail for… |
| [`examples/05-server-login.php`](examples/05-server-login.php) | Server-side login + register. |

## API methods

Every method is documented on its own page under [`docs/`](docs/). The full surface:

| Method | What it does |
| --- | --- |
| [`send`](docs/send.md) | Send a message over a verified domain. Pass `templateId` (+ optional `templateData`) to… |
| [`sendBatch`](docs/sendBatch.md) | Send one personalized message per recipient (up to 50) in a single call. Shared fields… |
| [`sendEvent`](docs/sendEvent.md) | Record one application-level fact about a user — `user.created`, `trial.expiring`… |
| [`listEvents`](docs/listEvents.md) | List recorded events, newest first — the surface for confirming a POST landed and for… |
| [`listEventNames`](docs/listEventNames.md) | List the distinct event names this account works with, so an editor can offer them… |
| [`listSequences`](docs/listSequences.md) | List your sequences, newest first, each with live enrollment counts. Archived sequences… |
| [`createSequence`](docs/createSequence.md) | Create a sequence: a declared input shape, the steps a contact walks over time, and zero… |
| [`getSequence`](docs/getSequence.md) | Get one sequence with its definition and live enrollment counts. |
| [`updateSequence`](docs/updateSequence.md) | Edit a sequence. Changing the STEPS bumps its version and contacts already in flight keep… |
| [`deleteSequence`](docs/deleteSequence.md) | Delete a sequence and retire every contact still walking it. The response reports how… |
| [`listTriggers`](docs/listTriggers.md) | List the triggers attached to a sequence — the doors into it. |
| [`createTrigger`](docs/createTrigger.md) | Attach a trigger: when this event arrives, enroll the contact it is about. Attaching… |
| [`updateTrigger`](docs/updateTrigger.md) | Edit a trigger, or toggle `enabled` to switch the door off without deleting it. Either… |
| [`deleteTrigger`](docs/deleteTrigger.md) | Detach a trigger. Stops future enrollments through that door and nothing else. |
| [`startSequence`](docs/startSequence.md) | Start a sequence for one contact, directly — when your code already knows WHICH sequence… |
| [`stopSequence`](docs/stopSequence.md) | Stop whatever is chasing someone. Pass the `cancelKey` you set when starting — so you… |
| [`listEnrollments`](docs/listEnrollments.md) | List who is in a sequence and where each of them is. Filter with `status`. |
| [`getEnrollment`](docs/getEnrollment.md) | Get one enrollment — which sequence, which step, and what happens next. |
| [`listEnrollmentRuns`](docs/listEnrollmentRuns.md) | Every step this enrollment has executed, with the outcome and the reason for it. This is… |
| [`cancelEnrollment`](docs/cancelEnrollment.md) | Cancel one specific run by its enrollment id — the per-row action when you are looking at… |
| [`uploadAttachment`](docs/uploadAttachment.md) | Upload a file to MailKite storage and get back a secure, time-limited URL. Reference the… |
| [`listTemplates`](docs/listTemplates.md) | List your saved email templates (light metadata only — no body). Use getTemplate for the… |
| [`listBaseTemplates`](docs/listBaseTemplates.md) | List the premade base templates (light metadata). Clone one with createTemplate({ baseId… |
| [`getTemplate`](docs/getTemplate.md) | Get one template (full: subject, html, text, theme). Works for your templates (tpl_…) and… |
| [`createTemplate`](docs/createTemplate.md) | Create a template. Pass `baseId` to clone a base template into your own, or provide… |
| [`listDomains`](docs/listDomains.md) | List your domains, each with its webhook URL. |
| [`createDomain`](docs/createDomain.md) | Add a domain. Returns the domain + DNS records. Paid plans may pass `email_provider_id`… |
| [`suggestSubdomain`](docs/suggestSubdomain.md) | Suggest a free, currently-unclaimed subdomain label to prefill the input with, plus the… |
| [`checkSubdomain`](docs/checkSubdomain.md) | Check whether a free subdomain label can be claimed. Read-only and cheap — call it as the… |
| [`claimSubdomain`](docs/claimSubdomain.md) | Claim a free MailKite subdomain — a `<label>.<base>` host on a zone we run (call… |
| [`getDomain`](docs/getDomain.md) | Get one domain with DNS records + webhook. |
| [`deleteDomain`](docs/deleteDomain.md) | Remove a domain. |
| [`verifyDomain`](docs/verifyDomain.md) | Check DNS and update status. |
| [`setWebhook`](docs/setWebhook.md) | Set or replace the domain's catch-all webhook. |
| [`setTrackingWebhook`](docs/setTrackingWebhook.md) | Set or replace the domain's dedicated tracking-event webhook: an HTTPS endpoint that… |
| [`deleteTrackingWebhook`](docs/deleteTrackingWebhook.md) | Remove the domain's tracking-event webhook (engagement events stop). |
| [`setWebhookEvents`](docs/setWebhookEvents.md) | Opt the domain's inbound webhook into engagement events — one webhook, all events. Pass… |
| [`deleteWebhookEvents`](docs/deleteWebhookEvents.md) | Opt the domain's inbound webhook back out of engagement events (inbound email.received… |
| [`deleteWebhook`](docs/deleteWebhook.md) | Remove the domain's webhook. |
| [`getWebhookSecret`](docs/getWebhookSecret.md) | Get this domain's webhook signing secret (whsec_…) — the per-route secret used to verify… |
| [`testWebhook`](docs/testWebhook.md) | Send a signed test event to the domain's webhook. |
| [`checkDomainAvailability`](docs/checkDomainAvailability.md) | Check whether a domain is available to register, and at what price. Read-only — no charge. |
| [`registerDomain`](docs/registerDomain.md) | Register (buy) a domain on the customer's behalf; provisions mail DNS and adds it to the… |
| [`listRoutes`](docs/listRoutes.md) | List inbound routing rules. |
| [`createRoute`](docs/createRoute.md) | Create a route (match, action, destination). |
| [`deleteRoute`](docs/deleteRoute.md) | Delete an inbound routing rule by id. Pair with createRoute to register and tear down a… |
| [`agent`](docs/agent.md) | Send a message to one of your inbox agents and get its reply. Defaults to the account's… |
| [`route`](docs/route.md) | Route a message to one of your registered routes (by `routeId` or `address`), running… |
| [`listMessages`](docs/listMessages.md) | List stored messages, newest first. Optionally filter with `search` (matches sender… |
| [`getMessage`](docs/getMessage.md) | Get a message with deliveries + attachments. |
| [`retryDelivery`](docs/retryDelivery.md) | Re-deliver a stored message to its webhook. |
| [`createRealtimeToken`](docs/createRealtimeToken.md) | Mint a short-lived, single-use token that authorises one Realtime API connection. For… |
| [`listLists`](docs/listLists.md) | List your contact lists (static, curated broadcast audiences), each with its member count. |
| [`createList`](docs/createList.md) | Create a contact list. Returns the list with its id (lst_…); add contacts with… |
| [`getList`](docs/getList.md) | Get one contact list with its member count. |
| [`updateList`](docs/updateList.md) | Rename a contact list. |
| [`deleteList`](docs/deleteList.md) | Delete a contact list. The list is removed; the contacts themselves are kept. |
| [`listListContacts`](docs/listListContacts.md) | List the contacts that are members of a list, newest first. Optionally page with `before`… |
| [`addListContacts`](docs/addListContacts.md) | Add contacts (by id, ctr_…) to a list. Returns how many were newly added; contacts… |
| [`removeListContact`](docs/removeListContact.md) | Remove one contact from a list (the contact itself is kept). |
| [`listBroadcasts`](docs/listBroadcasts.md) | List your broadcasts (one-to-many sends) with status and send stats. |
| [`createBroadcast`](docs/createBroadcast.md) | Create a broadcast draft. `from` is required; set `audience` to { type: "all" } or {… |
| [`getBroadcast`](docs/getBroadcast.md) | Get one broadcast with its status and recipient summary. |
| [`updateBroadcast`](docs/updateBroadcast.md) | Edit a draft broadcast (any of from/subject/audience/html/… ). Drafts only. |
| [`deleteBroadcast`](docs/deleteBroadcast.md) | Delete a broadcast draft. |
| [`sendBroadcast`](docs/sendBroadcast.md) | Send a broadcast now, or pass an ISO 8601 `scheduledAt` to schedule it. A one-click… |
| [`verifyWebhook`](docs/verifyWebhook.md) | Verify the `x-mailkite-signature` header on an inbound webhook delivery. Runs entirely… |
| [`replyOk`](docs/replyOk.md) | The acknowledgement body a webhook consumer returns to confirm it processed the event —… |
| [`replySpam`](docs/replySpam.md) | Control-mode reply a webhook consumer returns to tell MailKite to mark the message as… |
| [`replyDrop`](docs/replyDrop.md) | Control-mode reply a webhook consumer returns to tell MailKite to drop (discard) the… |
| [`replyBlockSender`](docs/replyBlockSender.md) | Control-mode reply a webhook consumer returns to tell MailKite to block the sender — the… |
| [`encrypt`](docs/encrypt.md) | Encrypt a UTF-8 string to a domain's RSA public key (SPKI/PEM), returning the at-rest… |
| [`decrypt`](docs/decrypt.md) | Decrypt a MailKite at-rest envelope JSON with your RSA private key (PKCS8/PEM), returning… |
| [`semanticSearch`](docs/semanticSearch.md) | Semantic search over the MailKite documentation — returns the most relevant doc sections… |
| [`registerOauthClient`](docs/registerOauthClient.md) | Register an OAuth client for this installation (RFC 7591 dynamic client registration) —… |
| [`exchangeOauthToken`](docs/exchangeOauthToken.md) | Exchange an authorization code for an access token (or rotate a refresh token) — step 3… |
| [`getApiKey`](docs/getApiKey.md) | Get the account's unrestricted API key (mk_live_…). Read-or-create: the first call mints… |
| [`rotateApiKey`](docs/rotateApiKey.md) | Rotate the account API key: the old key stops working immediately and a fresh one is… |
| [`listScopedKeys`](docs/listScopedKeys.md) | List the account's domain-scoped API keys. A scoped key can send and manage only its one… |
| [`createScopedKey`](docs/createScopedKey.md) | Create a key scoped to one domain. Ideal for per-site installs (e.g. a WordPress plugin)… |
| [`deleteScopedKey`](docs/deleteScopedKey.md) | Revoke a domain-scoped key. Takes effect immediately. |
| [`listAppPasswords`](docs/listAppPasswords.md) | List the account's app passwords. Each one opens a mailbox over IMAP and/or the mailbox… |
| [`createAppPassword`](docs/createAppPassword.md) | Create an app password for one domain and address pattern. Hand it to a mail client or an… |
| [`updateAppPassword`](docs/updateAppPassword.md) | Change what an app password covers — its label, address pattern, or protocols. The domain… |
| [`rotateAppPassword`](docs/rotateAppPassword.md) | Replace an app password's secret, keeping its scope. The old secret stops authenticating… |
| [`deleteAppPassword`](docs/deleteAppPassword.md) | Revoke an app password. Takes effect immediately — any IMAP session or API call using it… |
| [`listMailboxMessages`](docs/listMailboxMessages.md) | List a mailbox's messages, newest first. Authenticated with an app password granting… |
| [`getMailboxMessageRaw`](docs/getMailboxMessageRaw.md) | Fetch one message's raw RFC822 bytes from a mailbox. Same app password auth as the list. |
| [`setMailboxMessageFlags`](docs/setMailboxMessageFlags.md) | Replace a message's IMAP flags (e.g. mark it `Seen`). Flags set here are the same ones an… |
| [`getUsage`](docs/getUsage.md) | Current billing-period usage: emails used vs the plan's included bucket (null =… |
| [`listSuppressions`](docs/listSuppressions.md) | List suppressed addresses (unsubscribes, hard bounces, spam complaints, manual). Sends to… |
| [`addSuppression`](docs/addSuppression.md) | Suppress an address so this account never sends to it again (reason defaults to manual). |
| [`removeSuppression`](docs/removeSuppression.md) | Remove an address from the suppression list (URL-encode the email in the path). Removing… |
| [`register`](docs/register.md) | Create a MailKite account from just an email — no password. Returns the new account's API… |
| [`me`](docs/me.md) | The account behind this credential: email, whether it is verified (sending is blocked… |

## Use it from an AI agent — MCP + Agent connectors

MailKite speaks the [Model Context Protocol](https://modelcontextprotocol.io): every API method is a tool your AI assistant (Claude, Cursor, …) can call — send mail, manage domains, search the docs, and give an agent its own inbox. Full guide: **[https://mailkite.dev/docs/ai-agents](https://mailkite.dev/docs/ai-agents)**.

**Hosted (recommended) — one-click OAuth, no key to copy:**

```bash
claude mcp add --transport http mailkite https://mcp.mailkite.dev/mcp
```

In Claude Code you can also install the plugin:

```text
/plugin marketplace add mailkite/claude-code
/plugin install mailkite@mailkite
```

Any chat/UI agent: *"Add the MCP server at https://mcp.mailkite.dev/mcp and authenticate in the browser when prompted."*

**Local (static key, offline / CI):**

```json
{ "mcpServers": { "mailkite": { "command": "npx", "args": ["-y", "@mailkite/mcp"], "env": { "MAILKITE_API_KEY": "mk_live_…" } } } }
```

**Give an agent its own inbox.** Route inbound mail to a built-in **inbox agent** (the `agent` route action) and it answers, files, or escalates on its own — see [https://mailkite.dev/docs/ai-agents](https://mailkite.dev/docs/ai-agents).

## All MailKite libraries

Same contract, every language — pick the one for your stack (full list: [https://mailkite.dev/docs/libraries](https://mailkite.dev/docs/libraries)):

| Library | Repo | Distribution |
| --- | --- | --- |
| MailKite for Node.js | [`mailkite-node`](https://github.com/mailkite/mailkite-node) | npm |
| MailKite for Python | [`mailkite-python`](https://github.com/mailkite/mailkite-python) | PyPI |
| MailKite for Ruby | [`mailkite-ruby`](https://github.com/mailkite/mailkite-ruby) | RubyGems |
| MailKite for Java | [`mailkite-java`](https://github.com/mailkite/mailkite-java) | Maven Central |
| MailKite for PHP **(this repo)** | [`mailkite-php`](https://github.com/mailkite/mailkite-php) | Packagist |
| MailKite for Go | [`mailkite-go`](https://github.com/mailkite/mailkite-go) | Go modules |
| @mailkite/cli | [`mailkite-cli`](https://github.com/mailkite/mailkite-cli) | npm |
| @mailkite/mcp | [`mailkite-mcp`](https://github.com/mailkite/mailkite-mcp) | npm |
| @mailkite/client | [`mailkite-js`](https://github.com/mailkite/mailkite-js) | npm |
| @mailkite/expo | [`mailkite-expo`](https://github.com/mailkite/mailkite-expo) | npm |
| MailKiteClient | [`mailkite-swift`](https://github.com/mailkite/mailkite-swift) | Swift Package Manager |
| dev.mailkite:mailkite-client | [`mailkite-kotlin`](https://github.com/mailkite/mailkite-kotlin) | Maven Central |
| mailkite_client | [`mailkite-flutter`](https://github.com/mailkite/mailkite-flutter) | pub.dev |

## Docs & links

- 📚 **Documentation:** https://mailkite.dev/docs
- 📦 **This library's guide:** https://mailkite.dev/docs/libraries
- 🤖 **AI agents (MCP + inbox agents):** https://mailkite.dev/docs/ai-agents
- 🌐 **Website:** https://mailkite.dev
- 🧭 **All libraries:** https://mailkite.dev/docs/libraries

<sub>Generated from the shared MailKite API contract. © MailKite.</sub>
