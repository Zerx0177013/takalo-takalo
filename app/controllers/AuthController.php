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
    }
    public function isLogged()
    {
        $authModel = new AuthModel($this->app->db());
        return $authModel->isLoggedIn();
    }
    public function login($email, $password)
    {
        $db = $this->app->db();
        $model = new UserModel($db);
        $authModel = new AuthModel($db);
        $val = $model->checkInfo($email, $password);
        if ($val == null)
            return null;
        else
            $authModel->login($val['idUser'], $val);
        return $val;
    }
    public function logOut()
    {
        $authModel = new AuthModel($this->app->db());
        $authModel->logout();

    }
    public function checkLogin($else, $callback = null)
    {
        if ($this->isLogged()) {
            if ($callback !== null)
                $this->app->render($else, $callback);
            else
                $this->app->render($else);
        } else
            $this->app->redirect('/login');
    }
    public function dashboard()
    {
        if (!$this->isLogged()) {
            $this->app->redirect('/');
        }
        $authModel = new AuthModel($this->app->pdo()) ;
        if($_SESSION['isAdmin'])  $this->app->redirect('/');
        else $this->app->render('dashboard') ;
    }

}