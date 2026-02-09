<?php
namespace app\models;

class UserModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getNumberOfUsers(): int
    {
        $stmt = $this->db->query('SELECT * FROM `V_COUNT_USERS`');
        return (int) $stmt->fetchColumn("total_users");
    }

    public function checkEmail(string $email){
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM `user` WHERE email = :email');
            $stmt->execute([':email' => $email]);
            return (int) $stmt->fetchColumn() > 0;      
    }

    public function checkInfo($email , $password){
        $stmt = $this->db->prepare('SELECT idUser FROM `user` WHERE email = :email AND password = :password');
        $stmt->execute([':email' => $email, ':password' => $password]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
}
