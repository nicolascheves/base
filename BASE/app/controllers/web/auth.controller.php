<?php
require_once './app/models/user.model.php';
require_once './app/views/auth.view.php';

class AuthController{
    private $userModel;
    private $view;

    public function __construct(){
        $this->userModel = new UserModel();
        $this->view = new AuthView();
    }

    public function showLogin($req, $res){
        $this->view->showLogin("", $req->user ?? null);
    }

    public function doLogin($req, $res){
        if (empty($_POST['user']) || empty($_POST['password'])) {
            return $this->view->showLogin("Faltan datos obligatorios", $req->user ?? null);
        }

        $user = $_POST['user'];
        $password = $_POST['password'];

        $userFromDB = $this->userModel->getByUser($user);

        if ($userFromDB && password_verify($password, $userFromDB->password)) {
            $_SESSION['USER_ID'] = $userFromDB->id;
            $_SESSION['USER_NAME'] = $userFromDB->users;

            header("Location: " . BASE_URL . "home");
            exit;
        }

        return $this->view->showLogin("Usuario o contraseña incorrecta",$req->user ?? null);
    }

    public function logout($req, $res){
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }
}