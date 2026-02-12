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
            $statement = $this->pdo->prepare('
                SELECT i.*, c.name as category, u.username as ownerUsername, u.idUser as ownerId
                FROM `item` i 
                LEFT JOIN `categorie` c ON i.idcategorie = c.idcategorie 
                LEFT JOIN `user` u ON i.idUser = u.idUser
                WHERE i.idItem = :id 
                LIMIT 1
            ');
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
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idUser = :idSelf');
            $statement->execute([':idSelf' => $idSelf]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAllItemsExceptSelf($idSelf)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idUser != :idSelf');
            $statement->execute([':idSelf' => $idSelf]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }


    public function createItem($name, $description, $price, $categoryId, $userId, $arrayOfImageUrls)
    {
        try {
            $statement = $this->pdo->prepare('INSERT INTO `item` (name, description, price, idcategorie, idUser) VALUES (:name, :description, :price, :categoryId, :userId)');
            $statement->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':categoryId' => $categoryId,
                ':userId' => $userId
            ]);
            $this->addImagesToAnItem($this->pdo->lastInsertId(), $arrayOfImageUrls);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }

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

    public function searchItemsByName($name)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE name LIKE :name');
            $statement->execute([':name' => '%' . $name . '%']);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function searchItemsByCategory($categoryId)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idcategorie = :categoryId');
            $statement->execute([':categoryId' => $categoryId]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAllImagesOfAnItem($idItem)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `imageItem` WHERE idItem = :idItem');
            $statement->execute([':idItem' => $idItem]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getFirstImageOfAnItem($idItem)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `imageItem` WHERE idItem = :idItem LIMIT 1');
            $statement->execute([':idItem' => $idItem]);
            $image = $statement->fetch(PDO::FETCH_ASSOC);
            return $image === false ? null : $image;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function addImagesToAnItem($idItem, $imageInformationArray)
    {
        if (empty($imageInformationArray)) {
            return 0;
        }

        try {
            $statement = $this->pdo->prepare('INSERT INTO `imageItem` (idItem, imageURL) VALUES (:idItem, :imageURL)');
            $insertedCount = 0;

            foreach ($imageInformationArray as $imageUrl) {
                $statement->execute([
                    ':idItem' => $idItem,
                    ':imageURL' => $imageUrl
                ]);
                $insertedCount++;
            }

            return $insertedCount;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getItemsByPriceRange($minPrice, $maxPrice)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE price >= :minPrice AND price <= :maxPrice');
            $statement->execute([
                ':minPrice' => $minPrice,
                ':maxPrice' => $maxPrice
            ]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getItemsByReferencePrice($referencePrice, $rangeOffset = 5, $idSelf)
    {
        try {
            $minPrice = max(0, $referencePrice - $rangeOffset);
            $maxPrice = $referencePrice + $rangeOffset;
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE price >= :minPrice AND price <= :maxPrice AND idUser != :idSelf');
            $statement->execute([
                ':minPrice' => $minPrice,
                ':maxPrice' => $maxPrice,
                ':idSelf' => $idSelf
            ]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getItemsByCategory($idCategory)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idcategorie = :idCategory');
            $statement->execute([':idCategory' => $idCategory]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getItemsByCategoryAndPriceRange($idCategory, $referencePrice, $rangeOffset = 5, $idSelf)
    {
        try {
            $minPrice = max(0, $referencePrice - $rangeOffset);
            $maxPrice = $referencePrice + $rangeOffset;
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idcategorie = :idCategory AND price >= :minPrice AND price <= :maxPrice AND idUser != :idSelf');
            $statement->execute([
                ':idCategory' => $idCategory,
                ':minPrice' => $minPrice,
                ':maxPrice' => $maxPrice,
                ':idSelf' => $idSelf
            ]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getItemsByUserId($userId)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `item` WHERE idUser = :userId');
            $statement->execute([':userId' => $userId]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function deleteImagesByItemId($itemId)
    {
        try {
            $statement = $this->pdo->prepare('DELETE FROM `imageItem` WHERE idItem = :itemId');
            $statement->execute([':itemId' => $itemId]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function deleteItemById($id)
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
