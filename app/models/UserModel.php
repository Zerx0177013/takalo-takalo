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
        $stmt = $this->db->prepare('SELECT idUser,username FROM `user` WHERE email = :email AND password = :password');
        $stmt->execute([':email' => $email, ':password' => $password]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($this->isAdmin($user['idUser'])){
            $user['isAdmin'] = true;
        }
        else{
            $user['isAdmin'] = false;
        }
        return $user ?: null; 
    }
    public function isAdmin($id){
        $stmtm = $this->db->prepare('SELECT COUNT(*) FROM `admin` WHERE idUser = :id');
        $stmtm->execute([':id' => $id]);
        return (int) $stmtm->fetchColumn() > 0;
    }
    
}
