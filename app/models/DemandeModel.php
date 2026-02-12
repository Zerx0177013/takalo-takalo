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

    public function getDemandeById($id)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `demande` WHERE idDemande = :id LIMIT 1');
            $statement->execute([':id' => $id]);
            $demande = $statement->fetch(PDO::FETCH_ASSOC);
            return $demande === false ? null : $demande;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function createDemande($idDemandeur, $idReceveur, $idObjetOffert, $idObjetDemande, $idDemandeStatus)
    {
        try {
            $statement = $this->pdo->prepare('INSERT INTO `demande` (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus) VALUES (:idDemandeur, :idReceveur, :idObjetOffert, :idObjetDemande, :idDemandeStatus)');
            $statement->execute([
                ':idDemandeur' => $idDemandeur,
                ':idReceveur' => $idReceveur,
                ':idObjetOffert' => $idObjetOffert,
                ':idObjetDemande' => $idObjetDemande,
                ':idDemandeStatus' => $idDemandeStatus
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAllDemandeToMyself($id)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `demande` WHERE idReceveur = :id ORDER BY createdAt DESC');
            $statement->execute([':id' => $id]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAllDemandeFromMyself($id)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `demande` WHERE idDemandeur = :id ORDER BY createdAt DESC');
            $statement->execute([':id' => $id]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAllDemandeFromMyselfWithDetails($id)
    {
        try {
            $sql = 'SELECT * FROM v_details_demandes WHERE idDemandeur = :id';
            
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAllDemandeToMyselfWithDetails($id)
    {
        try {
            $sql = 'SELECT * FROM v_details_demandes WHERE idReceveur = :id';
        
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function acceptDemande($id)
    {
        try {
            $statement = $this->pdo->prepare('UPDATE `demande` SET idDemandeStatus = 2, statusAt = NOW() WHERE idDemande = :id');
            $statement->execute([':id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function refuseDemande($id)
    {
        try {
            $statement = $this->pdo->prepare('UPDATE `demande` SET idDemandeStatus = 3, statusAt = NOW() WHERE idDemande = :id');
            $statement->execute([':id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getDemandsByUserId($userId)
    {
        try {
            $statement = $this->pdo->prepare(
                'SELECT * FROM `demande` WHERE idDemandeur = :userId OR idReceveur = :userId ORDER BY createdAt DESC'
            );
            $statement->execute([':userId' => $userId]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function deleteDemandsByItemId($itemId)
    {
        try {
            $statement = $this->pdo->prepare(
                'DELETE FROM `demande` WHERE idObjetOffert = :itemId OR idObjetDemande = :itemId'
            );
            $statement->execute([':itemId' => $itemId]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            return 0;
        }
    }
}
