<?php

require_once __DIR__ . '/../../libs/router/router.php';

final class ApiGuardMiddleware extends Middleware
{
    public function run($request, $response): bool
    {
        if (empty($request->user)) {
            header('WWW-Authenticate: Bearer realm="API"');
            $response->json(['error' => 'No autorizado'], 401);
            return false;
        }

        $roles = $request->user->roles ?? [];
        if (!is_array($roles) || !in_array('BANANA', $roles, true)) {
            $response->json(['error' => 'Permisos insuficientes'], 403);
            return false;
        }

        return true;
    }
}
