<?php

namespace app\controllers;

use app\models\UserModel;
use flight\Engine;

class RegisterController
{
    protected Engine $app;
    
    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    public function showForm(): void
    {
        $this->app->render('register');
    }

    public function register(): void
    {
        $username = $this->app->request()->data->username;
        $email = $this->app->request()->data->email;
        $password = $this->app->request()->data->password;
        $confirmPassword = $this->app->request()->data->confirm_password;

        // Validate inputs
        if (empty($username) || empty($email) || empty($password)) {
            $this->app->redirect('/register?error=empty_fields');
            return;
        }

        if ($password !== $confirmPassword) {
            $this->app->redirect('/register?error=password_mismatch');
            return;
        }

        $userModel = new UserModel($this->app->db());

        // Check if email already exists
        if ($userModel->checkEmail($email)) {
            $this->app->redirect('/register?error=email_exists');
            return;
        }

        // Hash the password
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hashedPassword = $password;

        // Register the user
        if ($userModel->register($username, $email, $hashedPassword)) {
            $this->app->redirect('/login?success=registered');
        } else {
            $this->app->redirect('/register?error=registration_failed');
        }
    }
}