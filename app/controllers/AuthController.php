<?php

namespace app\controllers;

use app\models\AuthModel;
use app\models\UserModel;


use flight\Engine;

use Flight;

class AuthController
{

    protected Engine $app;
    protected AuthModel $authModel;
    protected UserModel $userModel;
    public function __construct(Engine $app)
    {
        $this->app = $app;
        $this->authModel = new AuthModel(Flight::db());
        $this->userModel = new UserModel(Flight::db());
    }
    public function isLogged()
    {
        return $this->authModel->isLoggedIn();
    }
    public function login($email, $password)
    {
        $db = $this->app->db();
        $model = new UserModel($db);
        $val = $model->checkInfo($email, $password);
        $this->authModel->login($val['idUser'],$val);
        return $val;
    }
    public function logOut()
    {
    $this->authModel->logout();
    }
}