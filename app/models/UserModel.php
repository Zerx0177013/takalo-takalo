<?php

namespace app\models;

class UserModel
{
  private $db ;
    public function __construct($db)
    {
$this->db = $db;
    }
    public function getNumberOfUsers(): int
    {
        $stmt = $this->db->query('SELECT * FROM `V_COUNT_USERS`');
        return (int) $stmt->fetchColumn("total_users");
    }

}
