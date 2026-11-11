<?php

require_once __DIR__ . '/../../libs/router/router.php';

final class WebGuardMiddleware extends Middleware
{
    public function run($request, $response): bool
    {
        if (!empty($request->user)) {
            return true;
        }

        header('Location: ' . BASE_URL . 'login', true, 302);
        return false;
    }
}
