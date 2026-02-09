<?php

namespace app\models;

use PDO;
use PDOException;

class CategoryModel
{
    private $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAllCategories()
    {
        try {
            $statement = $this->pdo->query('SELECT idcategorie, name FROM `categorie`');
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getCategoryById($id)
    {
        try {
            $statement = $this->pdo->prepare('SELECT idcategorie, name FROM `categorie` WHERE idcategorie = :id LIMIT 1');
            $statement->execute([':id' => $id]);
            $category = $statement->fetch(PDO::FETCH_ASSOC);
            return $category === false ? null : $category;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function createCategory($name)
    {
        try {
            $statement = $this->pdo->prepare('INSERT INTO `categorie` (name) VALUES (:name)');
            $statement->execute([':name' => $name]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function updateCategory($id, $name)
    {
        try {
            $statement = $this->pdo->prepare('UPDATE `categorie` SET name = :name WHERE idcategorie = :id');
            $statement->execute([':name' => $name, ':id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteCategory($id)
    {
        try {
            $statement = $this->pdo->prepare('DELETE FROM `categorie` WHERE idcategorie = :id');
            $statement->execute([':id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
