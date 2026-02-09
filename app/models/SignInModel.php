<?php
declare(strict_types=1);

namespace app\models;

use PDO;
use PDOException;

class SignInModel
{
    private PDO $pdo;
    private string $error = '';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function register(string $username, string $email, string $password): ?UserModel
    {
        $username = trim($username);
        $email = trim($email);
        $password = trim($password);

        if ($this->isUsernameValid($username) === false) {
            $this->error = 'Nom d\'utilisateur invalide (3-50 caractères alphanumériques, _ et -).';
            return null;
        }

        if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->error = 'Email invalide.';
            return null;
        }

        if ($this->isPasswordStrong($password) === false) {
            $this->error = 'Mot de passe trop faible (8+ caractères, majuscule, minuscule, chiffre).';
            return null;
        }

        try {
            $exists = $this->pdo->prepare('SELECT idUser FROM `user` WHERE email = :email OR username = :username LIMIT 1');
            $exists->execute([':email' => $email, ':username' => $username]);
            if ($exists->fetchColumn() !== false) {
                $this->error = 'Email ou nom d\'utilisateur déjà utilisé.';
                return null;
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $this->pdo->prepare('INSERT INTO `user` (username, email, password) VALUES (:username, :email, :password)');
            $insert->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hash,
            ]);

            $id = $this->pdo->lastInsertId();
            return new UserModel($id === '' ? 0 : (int) $id, $username, $email, $hash);
        } catch (PDOException $e) {
            $this->error = 'Erreur base de données.';
            return null;
        }
    }

    public function getError(): string
    {
        return $this->error;
    }

    private function isUsernameValid(string $username): bool
    {
        $length = strlen($username);
        if ($length < 3 || $length > 50) {
            return false;
        }

        return (bool) preg_match('/^[A-Za-z0-9_-]+$/', $username);
    }

    private function isPasswordStrong(string $password): bool
    {
        if (strlen($password) < 8) {
            return false;
        }

        $hasUpper = preg_match('/[A-Z]/', $password);
        $hasLower = preg_match('/[a-z]/', $password);
        $hasDigit = preg_match('/[0-9]/', $password);

        return $hasUpper && $hasLower && $hasDigit;
    }
}
