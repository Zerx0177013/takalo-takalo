<?php

namespace app\models;

use PDO;
use PDOException;

class DemandModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createDemande($idDemandeur, $idReceveur, $idObjetOffert, $idObjetDemande)
    {
        try {
            // Status 1 = EN_ATTENTE
            $statement = $this->pdo->prepare(
                'INSERT INTO `demande` (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt) 
                 VALUES (:idDemandeur, :idReceveur, :idObjetOffert, :idObjetDemande, 1, NOW())'
            );
            $statement->execute([
                ':idDemandeur' => $idDemandeur,
                ':idReceveur' => $idReceveur,
                ':idObjetOffert' => $idObjetOffert,
                ':idObjetDemande' => $idObjetDemande
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getDemandById($id)
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM `demande` WHERE idDemande = :id LIMIT 1');
            $statement->execute([':id' => $id]);
            $demand = $statement->fetch(PDO::FETCH_ASSOC);
            return $demand === false ? null : $demand;
        } catch (PDOException $e) {
            return null;
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
