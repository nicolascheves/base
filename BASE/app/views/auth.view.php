<?php

class AuthView {

    public function showLogin($error, $user) {
        require_once './templates/form.login.phtml';
    }

    public function showError($error, $user) {
        echo "<h1>$error</h1>";
    }
}

