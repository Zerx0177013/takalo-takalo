<?php

namespace app\models;

use PDO;
use PDOException;

class CategoryModel
{
    private PDO $pdo;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAllCategories(): array
    {
        try {
            $statement = $this->pdo->query('SELECT idcategorie, name FROM `categorie`');
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
