<?php

namespace app\models;

use PDO;
use PDOException;

class EchangeModel
{
    private $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getNombreEchangeReussi(){
        try {
            $sql = 'SELECT COUNT(*) as total FROM historiqueEchange';
            $statement = $this->pdo->query($sql);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
    
   
}
