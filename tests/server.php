<?php

declare(strict_types=1);

// Mock router for the PHP SDK unit tests, served by `php -S`. It echoes the
// request back as JSON so the test can assert what the SDK put on the wire, and
// supports two control paths:
//   GET/...  /__error/<status>/<message>  → that status with {"error": message}
//   ...      /__empty                       → 204 with an empty body

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$ctype = $_SERVER['CONTENT_TYPE'] ?? '';
$raw = file_get_contents('php://input');

if (preg_match('#^/__error/(\d+)/(.*)$#', $path, $m)) {
    http_response_code((int) $m[1]);
    header('Content-Type: application/json');
    echo json_encode(['error' => urldecode($m[2])]);
    return;
}

if ($path === '/__empty') {
    http_response_code(204);
    return;
}

http_response_code(200);
header('Content-Type: application/json');
echo json_encode([
    'method' => $method,
    'path' => $path,
    'auth' => $auth,
    'contentType' => $ctype,
    'body' => $raw === '' ? null : json_decode($raw, true),
]);
