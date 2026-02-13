<?php

namespace app\models;

use PDO;
use PDOException;

class HistoriqueModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function getHistoriqueObjet($itemId)
    {
        try {
            $sql = 'SELECT * FROM v_historique_objet WHERE idItem = :itemId ORDER BY dateEchange ASC';
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':itemId' => $itemId]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function createEchange($idDemande, $idDemandeur, $idOffreur, $idObjetOffert, $idObjetDemande)
    {
        try {
            $sql = 'INSERT INTO historiqueEchange (idDemande, idDemandeur, idOffreur, idObjetOffert, idObjetDemande) 
                    VALUES (:idDemande, :idDemandeur, :idOffreur, :idObjetOffert, :idObjetDemande)';
            $statement = $this->pdo->prepare($sql);
            $statement->execute([
                ':idDemande' => $idDemande,
                ':idDemandeur' => $idDemandeur,
                ':idOffreur' => $idOffreur,
                ':idObjetOffert' => $idObjetOffert,
                ':idObjetDemande' => $idObjetDemande
            ]);
            return (int) $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }
    public function updateItemOwner($itemId, $newOwnerId)
    {
        try {
            $sql = 'UPDATE item SET idUser = :newOwnerId WHERE idItem = :itemId';
            $statement = $this->pdo->prepare($sql);
            $statement->execute([
                ':newOwnerId' => $newOwnerId,
                ':itemId' => $itemId
            ]);
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
