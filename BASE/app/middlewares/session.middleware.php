<?php

require_once __DIR__ . '/../../libs/router/router.php';

final class SessionMiddleware extends Middleware
{
    public function run($request, $response): bool
    {
        if (isset($_SESSION['USER_ID'])) {
            $request->user = (object) [
                'id' => $_SESSION['USER_ID'],
                'username' => $_SESSION['USER_NAME'] ?? '',
            ];
        } else {
            $request->user = null;
        }

        return true;
    }
}
