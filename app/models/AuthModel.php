<?php
namespace app\models;

use flight\Engine;
use PDO;

class AuthModel
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->startSession();
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function isLoggedIn(): bool
    {
        return (!empty($_SESSION['idUser'])|| isset($_SESSION['isAdmin']));
    }
    public function login($userId, $user)
    {
        $_SESSION['idUser'] = $userId;
        $_SESSION['username'] = $user['username'];
        if (isset($user['isAddmin']) && $user['isAdmin'] == 1)
            $_SESSION['isAddmin'] = $user['isAddmin'];
    }
    public function logout()
    {
        session_unset();
        session_destroy();
    }
}