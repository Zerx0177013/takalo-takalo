<?php

namespace app\models;

use PDO;
use PDOException;

class ItemModel
{
    private PDO $pdo;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAllItems()
    {
        try {
            $statement = $this->pdo->query('SELECT * FROM `item`');
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getItemById($id)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idItem = :id LIMIT 1');
            $statement->execute([':id' => $id]);
            $item = $statement->fetch(PDO::FETCH_ASSOC);
            return $item === false ? null : $item;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAllItemsSelf($idSelf)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idItem = :idSelf');
            $statement->execute([':idSelf' => $idSelf]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAllItemsExceptSelf($idSelf)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idItem != :idSelf');
            $statement->execute([':idSelf' => $idSelf]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // public function createItem($name)
    // {
    //     try {
    //         $statement = $this->pdo->prepare('INSERT INTO `item` (name) VALUES (:name)');
    //         $statement->execute([':name' => $name]);
    //         return $this->pdo->lastInsertId();
    //     } catch (PDOException $e) {
    //         return null;
    //     }
    // }

    // public function updateItem($id, $name)
    // {
    //     try {
    //         $statement = $this->pdo->prepare('UPDATE `item` SET name = :name WHERE idItem = :id');
    //         $statement->execute([':name' => $name, ':id' => $id]);
    //         return $statement->rowCount() > 0;
    //     } catch (PDOException $e) {
    //         return false;
    //     }
    // }

    public function deleteItem($id)
    {
        try {
            $statement = $this->pdo->prepare('DELETE FROM `item` WHERE idItem = :id');
            $statement->execute([':id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
