<?php

declare(strict_types=1);

// Unit tests for the MailKite PHP SDK (dependency-free — no PHPUnit needed).
// Covers request(), every endpoint method, and verifyWebhook. Boots a local
// `php -S` mock (tests/server.php) and points the client at it.
//
// Run with:  php tests/run.php

require __DIR__ . '/../src/MailKiteException.php';
require __DIR__ . '/../src/Client.php';

use MailKite\Client;
use MailKite\MailKiteException;

$failures = 0;
$checks = 0;
function check(string $label, bool $cond): void
{
    global $failures, $checks;
    $checks++;
    if ($cond) {
        echo "ok  : $label\n";
    } else {
        $failures++;
        echo "FAIL: $label\n";
    }
}

// ---- boot the mock server ---------------------------------------------------
$port = random_int(20000, 40000);
$host = "127.0.0.1:$port";
$proc = proc_open(
    [PHP_BINARY, '-S', $host, __DIR__ . '/server.php'],
    [0 => ['pipe', 'r'], 1 => ['file', '/dev/null', 'w'], 2 => ['file', '/dev/null', 'w']],
    $pipes
);
if (!is_resource($proc)) {
    fwrite(STDERR, "could not start php -S\n");
    exit(1);
}
// Wait for the server to accept connections.
for ($i = 0; $i < 50; $i++) {
    $fp = @fsockopen('127.0.0.1', $port, $e, $s, 0.1);
    if ($fp) {
        fclose($fp);
        break;
    }
    usleep(100000);
}

$key = 'mk_live_test';
$base = "http://$host";
$mk = new Client($key, $base);

try {
    // ---- constructor --------------------------------------------------------
    $trimmed = new Client($key, "$base///");
    $echo = $trimmed->listDomains();
    check('base URL trims trailing slashes', $echo['path'] === '/api/domains');

    // ---- request() ----------------------------------------------------------
    $echo = $mk->request('POST', '/v1/send', ['a' => 1]);
    check('request sends Bearer auth', $echo['auth'] === "Bearer $key");
    check('request sets JSON content-type', strpos($echo['contentType'], 'application/json') !== false);
    check('request serializes the JSON body', $echo['body'] === ['a' => 1]);

    $echo = $mk->request('GET', '/api/domains');
    check('request with no body sends no payload', $echo['body'] === null);
    check('request with no body sends no content-type', $echo['contentType'] === '');

    check('request returns null for an empty body', $mk->request('DELETE', '/__empty') === null);

    try {
        $mk->request('GET', '/__error/404/not_found');
        check('request throws on error', false);
    } catch (MailKiteException $e) {
        check('error carries status', $e->status === 404);
        check('error carries message', $e->getMessage() === 'not_found');
        check('error carries body', is_array($e->body) && $e->body['error'] === 'not_found');
    }

    try {
        $mk->request('GET', '/__error/500/');
        check('request throws on 500', false);
    } catch (MailKiteException $e) {
        check('error status 500', $e->status === 500);
    }

    // ---- endpoint methods ---------------------------------------------------
    $cases = [
        [fn () => $mk->send(['from' => 'a', 'to' => 'b', 'subject' => 's', 'text' => 't']), 'POST', '/v1/send', ['from' => 'a', 'to' => 'b', 'subject' => 's', 'text' => 't']],
        [fn () => $mk->listDomains(), 'GET', '/api/domains', null],
        [fn () => $mk->createDomain(['domain' => 'x.dev']), 'POST', '/api/domains', ['domain' => 'x.dev']],
        [fn () => $mk->getDomain('dom_1'), 'GET', '/api/domains/dom_1', null],
        [fn () => $mk->deleteDomain('dom_1'), 'DELETE', '/api/domains/dom_1', null],
        [fn () => $mk->verifyDomain('dom_1'), 'POST', '/api/domains/dom_1/verify', null],
        [fn () => $mk->setWebhook('dom_1', ['url' => 'https://h.dev']), 'PUT', '/api/domains/dom_1/webhook', ['url' => 'https://h.dev']],
        [fn () => $mk->deleteWebhook('dom_1'), 'DELETE', '/api/domains/dom_1/webhook', null],
        [fn () => $mk->testWebhook('dom_1'), 'POST', '/api/domains/dom_1/webhook/test', null],
        [fn () => $mk->listRoutes(), 'GET', '/api/routes', null],
        [fn () => $mk->createRoute(['match' => '*@x', 'action' => 'webhook', 'destination' => 'u']), 'POST', '/api/routes', ['match' => '*@x', 'action' => 'webhook', 'destination' => 'u']],
        [fn () => $mk->listMessages(), 'GET', '/api/messages', null],
        [fn () => $mk->getMessage('msg_1'), 'GET', '/api/messages/msg_1', null],
        [fn () => $mk->retryDelivery('dlv_1'), 'POST', '/api/deliveries/dlv_1/retry', null],
    ];
    foreach ($cases as [$call, $method, $path, $body]) {
        $echo = $call();
        check("$method $path", $echo['method'] === $method && $echo['path'] === $path && $echo['body'] === $body);
    }

    // ---- verifyWebhook ------------------------------------------------------
    $secret = 'whsec_mailkite_test';
    $payload = '{"type":"email.received","id":"evt_123","message":"It works."}';
    $v1 = '3d790f831e170ddba4d001f27532bf2c1fc68ebed52eef72fe453dfa1196b03c';
    $header = "t=1750000000000,v1=$v1";

    check('verifyWebhook valid (tolerance 0)', $mk->verifyWebhook($header, $payload, $secret, 0) === true);
    check('verifyWebhook tampered body', $mk->verifyWebhook($header, "$payload ", $secret, 0) === false);
    check('verifyWebhook wrong secret', $mk->verifyWebhook($header, $payload, 'whsec_wrong', 0) === false);
    foreach (['', 'garbage', 't=1750000000000', "v1=$v1", "t=nan,v1=$v1"] as $h) {
        check("verifyWebhook malformed: '$h'", $mk->verifyWebhook($h, $payload, $secret, 0) === false);
    }
    // Default 5-minute window: fixed vector is stale; a freshly signed one passes.
    check('verifyWebhook default window rejects stale', $mk->verifyWebhook($header, $payload, $secret) === false);
    $t = (int) round(microtime(true) * 1000);
    $fresh = "t=$t,v1=" . hash_hmac('sha256', "$t.$payload", $secret);
    check('verifyWebhook default window accepts fresh', $mk->verifyWebhook($fresh, $payload, $secret) === true);
} finally {
    proc_terminate($proc);
    proc_close($proc);
}

echo $failures === 0 ? "\nALL $checks CHECKS PASS\n" : "\n$failures/$checks FAILED\n";
exit($failures === 0 ? 0 : 1);
