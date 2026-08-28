<?php

declare(strict_types=1);

namespace MailKite;

/**
 * MailKite SDK for PHP.
 *
 * Shape shared by every MailKite SDK: one low-level request() plus one thin
 * method per API endpoint. Uses ext-curl; no other dependencies.
 *
 *   $mk = new \MailKite\Client(getenv('MAILKITE_API_KEY'));
 *   $res = $mk->send([
 *     'from' => 'hello@app.mailkite.dev',
 *     'to' => 'ada@example.com',
 *     'subject' => 'Hi',
 *     'text' => 'It works.',
 *   ]);
 */
class Client
{
    /** Reject webhook events older than this (ms) to block replays. Pass 0 to disable. */
    public const DEFAULT_TOLERANCE_MS = 5 * 60 * 1000;

    private ?string $apiKey;
    /** @var callable|null Returns a fresh Bearer token per request (for short-lived OAuth tokens). */
    private $getToken;
    private string $baseUrl;

    /**
     * Authenticate with a Bearer token. Pass a token string (an API key `mk_live_…` OR an OAuth
     * access token — both are Bearer credentials), or an options array:
     *   ['apiKey' => '…'] / ['accessToken' => '…']  — a static token
     *   ['getToken' => fn() => $freshToken]          — a callback invoked before each request
     *   plus optional ['baseUrl' => '…'].
     */
    public function __construct($auth, string $baseUrl = 'https://api.mailkite.dev')
    {
        if (is_array($auth)) {
            $this->apiKey = $auth['apiKey'] ?? $auth['accessToken'] ?? null;
            $this->getToken = $auth['getToken'] ?? null;
            $baseUrl = $auth['baseUrl'] ?? $baseUrl;
        } else {
            $this->apiKey = $auth;
            $this->getToken = null;
        }
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /** The Bearer token for one request: from the getToken callback if set, else the static token. */
    private function token(): ?string
    {
        return $this->getToken !== null ? ($this->getToken)() : $this->apiKey;
    }

    /** Low-level request. Every method below is a one-liner on top of this. */
    public function request(string $method, string $path, $body = null)
    {
        $ch = curl_init($this->baseUrl . $path);
        $headers = ['Authorization: Bearer ' . $this->token()];
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($body !== null) {
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $raw = curl_exec($ch);
        if ($raw === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new MailKiteException(0, $err ?: 'request failed');
        }
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = $raw === '' ? null : json_decode($raw, true);
        if ($status < 200 || $status >= 300) {
            $message = is_array($data) && isset($data['error']) ? $data['error'] : "HTTP $status";
            throw new MailKiteException($status, $message, $data);
        }
        return $data;
    }

    // --- Sending ----------------------------------------------------------
    /**
     * Send a message. Keys: from, to, text/html, etc. `subject` is optional
     * when a template supplies it. Pass `templateId` (a tpl_… or base_…) to
     * render a stored template and `templateData` (an array) to fill its
     * variables.
     */
    public function send($message)
    {
        return $this->request('POST', '/v1/send', $message);
    }

    /**
     * Send one personalized message per recipient (up to 50) in a single
     * call. Keys: from, recipients, plus shared subject/html/text/
     * templateId/templateData/headers that form the base message. Each
     * `recipients` entry gets its own message to exactly one address, with
     * per-recipient `templateData` and `headers` merged over the shared
     * ones. The response reports each recipient's outcome in order.
     */
    public function sendBatch($batch)
    {
        return $this->request('POST', '/v1/send/batch', $batch);
    }

    /**
     * Extension → MIME type map for guessing the Content-Type of a raw upload.
     */
    private const ATTACHMENT_MIME_TYPES = [
        'pdf' => 'application/pdf',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        'csv' => 'text/csv',
        'txt' => 'text/plain',
        'html' => 'text/html',
        'json' => 'application/json',
        'zip' => 'application/zip',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ics' => 'text/calendar',
        'ical' => 'text/calendar',
    ];

    /** Guess a Content-Type from a filename's extension, defaulting to octet-stream. */
    private static function guessContentType(?string $filename): string
    {
        if ($filename === null || $filename === '') {
            return 'application/octet-stream';
        }
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return self::ATTACHMENT_MIME_TYPES[$ext] ?? 'application/octet-stream';
    }

    /**
     * Upload a file and get back a secure, time-limited URL to reference as a
     * send() attachment ({ filename, url }) or link inline — instead of
     * base64-inlining large files on every send.
     *
     * Provide the file ONE of four ways (checked in this order):
     *   - `url`     — MailKite fetches & re-hosts the file at this URL.
     *   - `bytes`   — raw binary string, uploaded as the request body.
     *   - `path`    — local file path; read off disk then uploaded as raw bytes.
     *   - `content` — base64-encoded string, sent as a JSON body.
     * Optional: `filename`, `contentType`, `retentionDays`.
     */
    public function uploadAttachment($file)
    {
        $filename = $file['filename'] ?? null;
        $contentType = $file['contentType'] ?? null;
        $retentionDays = $file['retentionDays'] ?? null;

        // 1. url → JSON body, MailKite fetches & re-hosts.
        if (isset($file['url'])) {
            $body = ['url' => $file['url']];
            if ($filename !== null) {
                $body['filename'] = $filename;
            }
            if ($contentType !== null) {
                $body['contentType'] = $contentType;
            }
            if ($retentionDays !== null) {
                $body['retentionDays'] = $retentionDays;
            }
            return $this->request('POST', '/v1/attachments', $body);
        }

        // 2. bytes → raw binary upload.
        if (isset($file['bytes'])) {
            return $this->requestBinary($file['bytes'], $filename, $contentType, $retentionDays);
        }

        // 3. path → read off disk, then raw binary upload.
        if (isset($file['path'])) {
            $path = $file['path'];
            $bytes = file_get_contents($path);
            if ($bytes === false) {
                throw new \RuntimeException("could not read file: $path");
            }
            if ($filename === null) {
                $filename = basename($path);
            }
            if ($contentType === null) {
                $contentType = self::guessContentType($filename);
            }
            return $this->requestBinary($bytes, $filename, $contentType, $retentionDays);
        }

        // 4. content → base64 JSON body (existing behavior).
        if (isset($file['content'])) {
            $body = ['content' => $file['content']];
            if ($filename !== null) {
                $body['filename'] = $filename;
            }
            if ($contentType !== null) {
                $body['contentType'] = $contentType;
            }
            if ($retentionDays !== null) {
                $body['retentionDays'] = $retentionDays;
            }
            return $this->request('POST', '/v1/attachments', $body);
        }

        throw new \InvalidArgumentException('uploadAttachment needs one of: url, bytes, path, content');
    }

    /**
     * Raw binary upload to /v1/attachments. Body is the raw file bytes (not JSON,
     * not multipart); filename and retentionDays go in the query string.
     */
    private function requestBinary(string $bytes, ?string $filename, ?string $contentType, $retentionDays)
    {
        $query = 'filename=' . rawurlencode((string) $filename);
        if ($retentionDays !== null) {
            $query .= '&retentionDays=' . rawurlencode((string) $retentionDays);
        }
        $contentType = $contentType ?? self::guessContentType($filename);

        $ch = curl_init($this->baseUrl . '/v1/attachments?' . $query);
        $headers = [
            'Authorization: Bearer ' . $this->token(),
            'Content-Type: ' . $contentType,
        ];
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $bytes);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $raw = curl_exec($ch);
        if ($raw === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new MailKiteException(0, $err ?: 'request failed');
        }
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = $raw === '' ? null : json_decode($raw, true);
        if ($status < 200 || $status >= 300) {
            $message = is_array($data) && isset($data['error']) ? $data['error'] : "HTTP $status";
            throw new MailKiteException($status, $message, $data);
        }
        return $data;
    }

    /**
     * Hand a message to the agent. Keys: text (required), plus optional
     * subject, from, html, routeId, address, model.
     */
    public function agent($message)
    {
        return $this->request('POST', '/v1/agent', $message);
    }

    /**
     * Route a message. Keys: from (required), plus optional routeId,
     * address, subject, text, html.
     */
    public function route($message)
    {
        return $this->request('POST', '/v1/route', $message);
    }

    // --- Templates --------------------------------------------------------
    public function listTemplates()
    {
        return $this->request('GET', '/api/templates');
    }

    public function listBaseTemplates()
    {
        return $this->request('GET', '/api/templates/base');
    }

    public function getTemplate(string $id)
    {
        return $this->request('GET', "/api/templates/$id");
    }

    public function createTemplate($body)
    {
        return $this->request('POST', '/api/templates', $body);
    }

    // --- Domains ----------------------------------------------------------
    public function listDomains()
    {
        return $this->request('GET', '/api/domains');
    }

    public function createDomain($body)
    {
        return $this->request('POST', '/api/domains', $body);
    }

    /**
     * Suggest a free, currently-unclaimed subdomain label to prefill the input with.
     * Read-only — suggesting does not reserve the name. Read `base` from the response
     * rather than hard-coding the pool zone.
     */
    public function suggestSubdomain()
    {
        return $this->request('GET', '/api/domains/subdomain/suggest');
    }

    /**
     * Check whether a free subdomain label can be claimed. Cheap enough to call as the
     * user types; `reason` explains a rejection and is safe to show verbatim.
     */
    public function checkSubdomain(string $name)
    {
        return $this->request('GET', '/api/domains/subdomain/check?name=' . rawurlencode($name));
    }

    /**
     * Claim a free managed subdomain (`<label>.<base>`). Comes back already verified
     * with an empty `dns` array — we host the zone, so there is nothing for the customer
     * to publish.
     */
    public function claimSubdomain($body)
    {
        return $this->request('POST', '/api/domains/subdomain', $body);
    }

    public function getDomain(string $id)
    {
        return $this->request('GET', "/api/domains/$id");
    }

    public function getWebhookSecret(string $id)
    {
        return $this->request('GET', "/api/domains/$id/webhook/secret");
    }

    public function deleteDomain(string $id)
    {
        return $this->request('DELETE', "/api/domains/$id");
    }

    public function verifyDomain(string $id)
    {
        return $this->request('POST', "/api/domains/$id/verify");
    }

    public function setWebhook(string $id, $body)
    {
        return $this->request('PUT', "/api/domains/$id/webhook", $body);
    }

    public function deleteWebhook(string $id)
    {
        return $this->request('DELETE', "/api/domains/$id/webhook");
    }

    public function setTrackingWebhook(string $id, $body)
    {
        return $this->request('PUT', "/api/domains/$id/tracking-webhook", $body);
    }

    public function deleteTrackingWebhook(string $id)
    {
        return $this->request('DELETE', "/api/domains/$id/tracking-webhook");
    }

    public function setWebhookEvents(string $id, $body)
    {
        return $this->request('PUT', "/api/domains/$id/webhook-events", $body);
    }

    public function deleteWebhookEvents(string $id)
    {
        return $this->request('DELETE', "/api/domains/$id/webhook-events");
    }

    public function testWebhook(string $id)
    {
        return $this->request('POST', "/api/domains/$id/webhook/test");
    }

    public function checkDomainAvailability(string $domain)
    {
        return $this->request('GET', '/api/domains/register/check?domain=' . rawurlencode($domain));
    }

    public function registerDomain($body)
    {
        return $this->request('POST', '/api/domains/register', $body);
    }

    // --- Docs -------------------------------------------------------------
    public function semanticSearch(string $query)
    {
        return $this->request('GET', '/v1/docs/search?query=' . rawurlencode($query));
    }

    // --- Account ------------------------------------------------------------
    /**
     * Create a MailKite account from just an email — no password. Returns the
     * new account's API key immediately; a verification link is emailed, and
     * sending stays blocked until the address is verified (poll me()). An
     * existing email returns 409 account_exists with no credentials. Keys:
     * email (required), plus optional channel/ref/referrer.
     */
    public function register($body)
    {
        return $this->request('POST', '/api/v1/provision', $body);
    }

    /**
     * The account behind this credential: email, whether it is verified
     * (sending is blocked until it is), and plan. Use to poll verification
     * state after register().
     */
    public function me()
    {
        return $this->request('GET', '/v1/me');
    }

    /**
     * Step 1 of linking an EXISTING account: register an OAuth client for this
     * installation (RFC 7591). No pre-shared secret — the client is public and proves
     * itself with PKCE. Public: no API key required.
     */
    public function registerOauthClient($body)
    {
        return $this->request('POST', '/oauth/register', $body);
    }

    /**
     * Step 3 of linking: exchange the authorization code for an access token, or rotate
     * a refresh token. Finish by calling getApiKey() with the access token and storing
     * the key. Public: no API key required.
     */
    public function exchangeOauthToken($body)
    {
        return $this->request('POST', '/oauth/token', $body);
    }

    /** Get the account's unrestricted API key (mk_live_…). Read-or-create: the first call mints it. */
    public function getApiKey()
    {
        return $this->request('GET', '/api/keys');
    }

    /**
     * Rotate the account API key: the old key stops working immediately and a
     * fresh one is returned. The plaintext is only shown here.
     */
    public function rotateApiKey()
    {
        return $this->request('POST', '/api/keys/rotate');
    }

    /**
     * List the account's domain-scoped API keys. A scoped key can send and
     * manage only its one domain — hand one to each site or CI job so a leak
     * burns only that surface.
     */
    public function listScopedKeys()
    {
        return $this->request('GET', '/api/keys/scoped');
    }

    /**
     * Create a key scoped to one domain. Ideal for per-site installs (e.g. a
     * WordPress plugin) — the site never holds the account master key. Keys:
     * domainId (required), name (optional).
     */
    public function createScopedKey($body)
    {
        return $this->request('POST', '/api/keys/scoped', $body);
    }

    /** Revoke a domain-scoped key. Takes effect immediately. */
    public function deleteScopedKey(string $id)
    {
        return $this->request('DELETE', "/api/keys/scoped/$id");
    }

    /**
     * List the account's app passwords. Each one opens a mailbox over IMAP and/or the mailbox
     * API, scoped to a domain and an address pattern within it.
     */
    public function listAppPasswords()
    {
        return $this->request('GET', '/api/app-passwords');
    }

    /**
     * Create an app password for one domain and address pattern. $body carries "domain"
     * (required) plus optional "address" (default "*"), "protocols" (default ["imap"]) and
     * "label". The secret is returned once and never again.
     */
    public function createAppPassword(array $body)
    {
        return $this->request('POST', '/api/app-passwords', $body);
    }

    /**
     * Edit an app password's label, address pattern and protocols. The domain is fixed for the
     * life of the password: repointing a live credential would hand its holder mail they were
     * never granted.
     */
    public function updateAppPassword(string $id, $body)
    {
        return $this->request('PATCH', "/api/app-passwords/$id", $body);
    }

    /**
     * Replace an app password's secret, keeping its scope. The old secret stops authenticating
     * immediately; the new one is returned once.
     */
    public function rotateAppPassword(string $id)
    {
        return $this->request('POST', "/api/app-passwords/$id/rotate");
    }

    /**
     * Revoke an app password. Takes effect immediately — any IMAP session or API call using it
     * stops authenticating.
     */
    public function deleteAppPassword(string $id)
    {
        return $this->request('DELETE', "/api/app-passwords/$id");
    }

    /**
     * List a mailbox's messages, newest first. Authenticated with an app password granting
     * "api" — this is how an agent reads its own inbox without an IMAP client.
     */
    public function listMailboxMessages(string $address, array $params = [])
    {
        $q = http_build_query(array_merge(['address' => $address], $params));
        return $this->request('GET', "/api/mailbox/messages?$q");
    }

    /** Fetch one message's raw RFC822 bytes from a mailbox. Same app password auth as the list. */
    public function getMailboxMessageRaw(int $uid, string $address)
    {
        $q = http_build_query(['address' => $address]);
        return $this->request('GET', "/api/mailbox/messages/$uid/raw?$q");
    }

    /**
     * Replace a message's IMAP flags (e.g. mark it "Seen"). Flags set here are the same ones an
     * IMAP client sees.
     */
    public function setMailboxMessageFlags(int $uid, string $address, string $flags)
    {
        $q = http_build_query(['address' => $address]);
        return $this->request('POST', "/api/mailbox/messages/$uid/flags?$q", ['flags' => $flags]);
    }

    /**
     * Current billing-period usage: emails used vs the plan's included bucket
     * (null = unlimited), AI actions, and the overage state that gates
     * sending. Powers quota meters in dashboards and integrations.
     */
    public function getUsage()
    {
        return $this->request('GET', '/api/billing/usage');
    }

    // --- Routes -----------------------------------------------------------
    public function listRoutes()
    {
        return $this->request('GET', '/api/routes');
    }

    public function createRoute($body)
    {
        return $this->request('POST', '/api/routes', $body);
    }

    public function deleteRoute(string $id)
    {
        return $this->request('DELETE', '/api/routes/' . $id);
    }

    // --- Messages & deliveries -------------------------------------------
    public function listMessages(?int $before = null, ?int $limit = null, ?string $search = null)
    {
        $query = [];
        if ($before !== null) {
            $query[] = 'before=' . rawurlencode((string) $before);
        }
        if ($limit !== null) {
            $query[] = 'limit=' . rawurlencode((string) $limit);
        }
        if ($search !== null) {
            $query[] = 'search=' . rawurlencode($search);
        }
        $path = '/api/messages' . (count($query) > 0 ? '?' . implode('&', $query) : '');
        return $this->request('GET', $path);
    }

    public function getMessage(string $id)
    {
        return $this->request('GET', "/api/messages/$id");
    }

    public function retryDelivery(string $id)
    {
        return $this->request('POST', "/api/deliveries/$id/retry");
    }

    /**
     * Replay a whole selection of webhook deliveries in one call. $body takes deliveryIds /
     * messageIds / threadIds (they combine), at most 50 ids per request. Always answers 200 with
     * a per-id `results` array, so branch on that rather than on the status.
     */
    public function retryDeliveries(array $body)
    {
        return $this->request('POST', '/api/deliveries/retry', $body);
    }

    /**
     * Every captured attempt for one delivery, newest first — the request we sent and the
     * response that came back. Captures are retained for 45 days.
     */
    public function listDeliveryAttempts(string $id)
    {
        return $this->request('GET', "/api/deliveries/$id/attempts");
    }

    /**
     * POST stored messages to one webhook route, including mail that arrived before the route
     * existed. $body is ['messageIds' => [...]], at most 50. Webhook routes only.
     */
    public function deliverToRoute(string $id, array $body)
    {
        return $this->request('POST', "/api/routes/$id/deliver", $body);
    }

    /** Stored messages this route could be asked to deliver, newest first. */
    public function listRouteCandidates(string $id, ?int $before = null, ?int $limit = null)
    {
        $query = [];
        if ($before !== null) {
            $query[] = 'before=' . rawurlencode((string) $before);
        }
        if ($limit !== null) {
            $query[] = 'limit=' . rawurlencode((string) $limit);
        }
        $path = "/api/routes/$id/candidates" . (count($query) > 0 ? '?' . implode('&', $query) : '');
        return $this->request('GET', $path);
    }

    // --- Realtime ---------------------------------------------------------
    /**
     * Mint a short-lived, single-use token that authorises one Realtime API connection.
     * Browsers need this because EventSource cannot set headers; the page passes it as
     * ?token= on GET /v1/realtime. Inherits this credential's scope, expires in five
     * minutes, and burns on first use.
     */
    public function createRealtimeToken()
    {
        return $this->request('POST', '/v1/realtime/token');
    }

    // --- Contact lists ----------------------------------------------------
    public function listLists()
    {
        return $this->request('GET', '/api/lists');
    }

    public function createList($body)
    {
        return $this->request('POST', '/api/lists', $body);
    }

    public function getList(string $id)
    {
        return $this->request('GET', "/api/lists/$id");
    }

    public function updateList(string $id, $body)
    {
        return $this->request('PATCH', "/api/lists/$id", $body);
    }

    public function deleteList(string $id)
    {
        return $this->request('DELETE', "/api/lists/$id");
    }

    public function listListContacts(string $id, ?int $before = null, ?int $limit = null)
    {
        $query = [];
        if ($before !== null) {
            $query[] = 'before=' . rawurlencode((string) $before);
        }
        if ($limit !== null) {
            $query[] = 'limit=' . rawurlencode((string) $limit);
        }
        $path = "/api/lists/$id/contacts" . (count($query) > 0 ? '?' . implode('&', $query) : '');
        return $this->request('GET', $path);
    }

    public function addListContacts(string $id, $body)
    {
        return $this->request('POST', "/api/lists/$id/contacts", $body);
    }

    public function removeListContact(string $id, string $contactId)
    {
        return $this->request('DELETE', "/api/lists/$id/contacts/$contactId");
    }

    // --- Suppressions -------------------------------------------------------
    /**
     * List suppressed addresses (unsubscribes, hard bounces, spam
     * complaints, manual). Sends to a suppressed address are dropped before
     * delivery.
     */
    public function listSuppressions()
    {
        return $this->request('GET', '/api/contacts/suppressions');
    }

    /**
     * Suppress an address so this account never sends to it again (reason
     * defaults to manual). Keys: email (required), reason/note (optional).
     */
    public function addSuppression($body)
    {
        return $this->request('POST', '/api/contacts/suppressions', $body);
    }

    /**
     * Remove an address from the suppression list. Removing an unsuppressed
     * address is a no-op success.
     */
    public function removeSuppression(string $email)
    {
        return $this->request('DELETE', '/api/contacts/suppressions/' . rawurlencode($email));
    }

    // --- Broadcasts -------------------------------------------------------
    public function listBroadcasts()
    {
        return $this->request('GET', '/api/broadcasts');
    }

    public function createBroadcast($body)
    {
        return $this->request('POST', '/api/broadcasts', $body);
    }

    public function getBroadcast(string $id)
    {
        return $this->request('GET', "/api/broadcasts/$id");
    }

    public function updateBroadcast(string $id, $body)
    {
        return $this->request('PATCH', "/api/broadcasts/$id", $body);
    }

    public function deleteBroadcast(string $id)
    {
        return $this->request('DELETE', "/api/broadcasts/$id");
    }

    public function sendBroadcast(string $id, $body = null)
    {
        return $this->request('POST', "/api/broadcasts/$id/send", $body);
    }

    // --- Webhooks ---------------------------------------------------------
    /**
     * Verify the `x-mailkite-signature` header on an inbound webhook delivery.
     * Local HMAC-SHA256 check — no network call. Pass the raw, unparsed body.
     *
     * @param int $toleranceMs reject events older than this many ms (0 disables).
     *
     * STATIC: verifying a signature needs no client — no base URL, no token — so requiring one is
     * a barrier with nothing behind it. Matches the Node, Ruby, Python, Go and .NET SDKs, which all
     * expose this at class/module level. PHP still permits `$client->verifyWebhook(...)` on a
     * static, so no existing caller breaks.
     */
    public static function verifyWebhook(string $signature, string $payload, string $secret, int $toleranceMs = self::DEFAULT_TOLERANCE_MS): bool
    {
        if ($signature === '') {
            return false;
        }
        $parts = [];
        foreach (explode(',', $signature) as $seg) {
            $i = strpos($seg, '=');
            if ($i === false) {
                continue;
            }
            $parts[trim(substr($seg, 0, $i))] = trim(substr($seg, $i + 1));
        }
        $t = $parts['t'] ?? null;
        $v1 = $parts['v1'] ?? null;
        if ($t === null || $v1 === null || $v1 === '' || preg_match('/\A-?\d+\z/', $t) !== 1) {
            return false;
        }
        // The t in the header is milliseconds since the epoch.
        if ($toleranceMs > 0) {
            $nowMs = (int) round(microtime(true) * 1000);
            if (abs($nowMs - (int) $t) > $toleranceMs) {
                return false;
            }
        }
        $expected = hash_hmac('sha256', $t . '.' . $payload, $secret);
        return hash_equals($expected, $v1);
    }

    /**
     * The canonical body an inbound webhook handler returns to ack an event.
     * Local, no network.
     */
    public function replyOk(): string
    {
        return '{"status":"ok"}';
    }

    /**
     * Control-mode reply telling MailKite to mark the message as spam.
     * Local, no network.
     */
    public function replySpam(): string
    {
        return '{"status":"spam"}';
    }

    /**
     * Control-mode reply telling MailKite to drop (discard) the message.
     * Local, no network.
     */
    public function replyDrop(): string
    {
        return '{"status":"drop"}';
    }

    /**
     * Control-mode reply telling MailKite to block the sender.
     * Local, no network.
     */
    public function replyBlockSender(): string
    {
        return '{"status":"ok","actions":[{"type":"block-sender"}]}';
    }

    // --- At-rest encryption ----------------------------------------------
    // Hybrid envelope, byte-compatible with MailKite's WebCrypto scheme:
    //   1. a fresh AES-256-GCM content key encrypts the plaintext,
    //   2. the content key is wrapped with the recipient's RSA-OAEP (SHA-256) public key.
    // Only RSA-OAEP-SHA256 is interoperable here; PHP's openssl_public_encrypt only
    // offers OAEP-SHA1, so we use phpseclib v3 for the key wrap/unwrap.

    /** Strip a PEM wrapper to its base64-decoded DER body. */
    private static function pemToDer(string $pem): string
    {
        $body = preg_replace('/-----BEGIN [^-]+-----|-----END [^-]+-----|\s+/', '', $pem);
        if ($body === '' || $body === null) {
            throw new \InvalidArgumentException('empty or malformed PEM');
        }
        $der = base64_decode($body, true);
        if ($der === false) {
            throw new \InvalidArgumentException('malformed PEM body');
        }
        return $der;
    }

    /**
     * Encrypt a UTF-8 string to an at-rest envelope (JSON string).
     * `$publicKey` is an RSA public key in SPKI/PEM form. Local, no network.
     */
    public function encrypt(string $plaintext, string $publicKey): string
    {
        $spkiDer = self::pemToDer($publicKey);
        $fp = strtolower(bin2hex(hash('sha256', $spkiDer, true)));

        // 1. Fresh AES-256-GCM content key + 12-byte IV; encrypt the plaintext.
        $rawKey = random_bytes(32);
        $iv = random_bytes(12);
        $tag = '';
        $ct = openssl_encrypt($plaintext, 'aes-256-gcm', $rawKey, OPENSSL_RAW_DATA, $iv, $tag, '', 16);
        if ($ct === false) {
            throw new \RuntimeException('AES-GCM encryption failed');
        }
        // WebCrypto appends the 16-byte auth tag to the ciphertext.
        $ciphertext = $ct . $tag;

        // 2. Wrap the content key with RSA-OAEP (SHA-256 hash + MGF1-SHA256).
        $rsa = \phpseclib3\Crypt\PublicKeyLoader::load($publicKey)
            ->withPadding(\phpseclib3\Crypt\RSA::ENCRYPTION_OAEP)
            ->withHash('sha256')
            ->withMGFHash('sha256');
        $wrapped = $rsa->encrypt($rawKey);

        return json_encode([
            'v' => 1,
            'keyAlg' => 'RSA-OAEP-256',
            'fp' => $fp,
            'enc' => 'A256GCM',
            'iv' => base64_encode($iv),
            'wrappedKey' => base64_encode($wrapped),
            'ciphertext' => base64_encode($ciphertext),
        ]);
    }

    /**
     * Decrypt an at-rest envelope (JSON string) back to its UTF-8 plaintext.
     * `$privateKey` is the matching RSA private key in PKCS#8/PEM form. Local, no network.
     */
    public function decrypt(string $envelope, string $privateKey): string
    {
        $env = json_decode($envelope, true);
        if (!is_array($env)) {
            throw new \InvalidArgumentException('malformed envelope JSON');
        }

        $iv = base64_decode($env['iv'], true);
        $wrappedKey = base64_decode($env['wrappedKey'], true);
        $ciphertext = base64_decode($env['ciphertext'], true);
        if ($iv === false || $wrappedKey === false || $ciphertext === false) {
            throw new \InvalidArgumentException('malformed envelope fields');
        }
        if (strlen($ciphertext) < 16) {
            throw new \InvalidArgumentException('ciphertext too short for GCM tag');
        }

        // Split the appended 16-byte GCM tag back off the ciphertext.
        $tag = substr($ciphertext, -16);
        $body = substr($ciphertext, 0, -16);

        // Unwrap the content key with RSA-OAEP (SHA-256 hash + MGF1-SHA256).
        $rsa = \phpseclib3\Crypt\PublicKeyLoader::load($privateKey)
            ->withPadding(\phpseclib3\Crypt\RSA::ENCRYPTION_OAEP)
            ->withHash('sha256')
            ->withMGFHash('sha256');
        $rawKey = $rsa->decrypt($wrappedKey);

        $plaintext = openssl_decrypt($body, 'aes-256-gcm', $rawKey, OPENSSL_RAW_DATA, $iv, $tag, '');
        if ($plaintext === false) {
            throw new \RuntimeException('AES-GCM decryption failed');
        }
        return $plaintext;
    }
}
