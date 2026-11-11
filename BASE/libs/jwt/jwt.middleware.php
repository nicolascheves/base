<?php

require_once __DIR__ . '/../router/router.php';
require_once __DIR__ . '/jwt.php';

final class JWTMiddleware extends Middleware
{
    public function run($request, $response): bool
    {
        $request->user = null;
        $authorization = trim((string) ($request->authorization ?? ''));

        if (preg_match('/^Bearer\s+([^\s]+)$/i', $authorization, $matches) === 1) {
            $request->user = validateJWT($matches[1]);
        }

        // Public endpoints remain accessible; protected routes use ApiGuardMiddleware.
        return true;
    }
}
