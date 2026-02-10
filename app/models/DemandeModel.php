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
        $statement = $this->pdo->prepare('SELECT * FROM `demande` WHERE idReceveur = :id LIMIT 1');
        $statement->execute([':id' => $id]);
        $demande = $statement->fetch(PDO::FETCH_ASSOC);
        return $demande === false ? null : $demande;
    }

    public function getAllDemandeFromMyself($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM `demande` WHERE idDemandeur = :id LIMIT 1');
        $statement->execute([':id' => $id]);
        $demande = $statement->fetch(PDO::FETCH_ASSOC);
        return $demande === false ? null : $demande;
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
}
