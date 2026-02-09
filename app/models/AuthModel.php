<?php
namespace app\models;

use flight\Engine;
use PDO;

class AuthModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->startSession();
    }

    private function startSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function isLoggedIn(): bool {
        return isset($_SESSION['idUser']);
    }
    public function login($userId) {
        $_SESSION['idUser'] = $userId;
    }
    public function logout() {
        session_unset();
        session_destroy();
    }
}