<?php

/** Obtain the signing key from the server environment, never from source control. */
function jwtSecret(): string
{
    $secret = getenv('JWT_SECRET');
    if (!is_string($secret) || strlen($secret) < 32) {
        throw new RuntimeException('JWT_SECRET must be configured and contain at least 32 characters.');
    }

    return $secret;
}

function base64UrlEncode(string $value): string
{
    return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
}

function base64UrlDecode(string $value)
{
    if ($value === '' || preg_match('/^[A-Za-z0-9_-]+$/', $value) !== 1) {
        return false;
    }

    $decoded = base64_decode(strtr($value, '-_', '+/') . str_repeat('=', (4 - strlen($value) % 4) % 4), true);
    return $decoded === false ? false : $decoded;
}

function createJWT(array $payload): string
{
    $header = base64UrlEncode(json_encode(['typ' => 'JWT', 'alg' => 'HS256'], JSON_THROW_ON_ERROR));
    $encodedPayload = base64UrlEncode(json_encode($payload, JSON_THROW_ON_ERROR));
    $signingInput = $header . '.' . $encodedPayload;
    $signature = base64UrlEncode(hash_hmac('sha256', $signingInput, jwtSecret(), true));

    return $signingInput . '.' . $signature;
}

function validateJWT(string $token): ?object
{
    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return null;
    }

    [$encodedHeader, $encodedPayload, $signature] = $parts;
    $headerJson = base64UrlDecode($encodedHeader);
    $payloadJson = base64UrlDecode($encodedPayload);
    $providedSignature = base64UrlDecode($signature);
    if ($headerJson === false || $payloadJson === false || $providedSignature === false) {
        return null;
    }

    $header = json_decode($headerJson);
    $payload = json_decode($payloadJson);
    if (!is_object($header) || ($header->alg ?? null) !== 'HS256' || !is_object($payload)) {
        return null;
    }

    $expectedSignature = hash_hmac('sha256', $encodedHeader . '.' . $encodedPayload, jwtSecret(), true);
    if (!hash_equals($expectedSignature, $providedSignature)) {
        return null;
    }

    if (!isset($payload->exp) || !is_numeric($payload->exp) || (int) $payload->exp <= time()) {
        return null;
    }

    return $payload;
}
