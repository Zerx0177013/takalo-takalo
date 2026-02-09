<?php

namespace app\models;

use PDO;
use PDOException;

class DemandeModel
{
    private $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllDemandes()
    {
        try {
            $statement = $this->pdo->query('SELECT * FROM `demande`');
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    

}
