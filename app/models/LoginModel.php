<?php
declare(strict_types=1);

namespace app\models;

use PDO;
use PDOException;

class LoginModel
{
    private PDO $pdo;
    private string $error = '';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticate(string $email, string $password): ?UserModel
    {
        $email = trim($email);
        $password = trim($password);

        if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->error = 'Email invalide.';
            return null;
        }

        if ($password === '' || strlen($password) < 8) {
            $this->error = 'Mot de passe trop court (8 caractères minimum).';
            return null;
        }

        try {
            $statement = $this->pdo->prepare('SELECT idUser, username, email, password FROM `user` WHERE email = :email LIMIT 1');
            $statement->execute([':email' => $email]);
            $row = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error = 'Erreur base de données.';
            return null;
        }

        if ($row === false) {
            $this->error = 'Identifiants invalides.';
            return null;
        }

        if (password_verify($password, $row['password']) === false) {
            $this->error = 'Identifiants invalides.';
            return null;
        }

        return UserModel::fromArray($row);
    }

    public function getError(): string
    {
        return $this->error;
    }
}
