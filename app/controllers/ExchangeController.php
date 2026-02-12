<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\ItemModel;
use app\models\DemandeModel;
use app\models\HistoriqueModel;

use flight\Engine;

class ExchangeController
{
    protected Engine $app;
    public function __construct(Engine $app)
    {
        $this->app = $app;
    }


    public function createExchange()
    {
        $pdo = $this->app->db();
        $demandModel = new DemandeModel($pdo);
        $itemModel = new ItemModel($pdo);


        $currentUserId = $_SESSION['idUser'];

        $idObjetOffert = $this->app->request()->data->idObjetOffert;
        $idObjetDemande = $this->app->request()->data->idObjetDemande;

        $itemDemande = $itemModel->getItemById($idObjetDemande);

        if (!$itemDemande) {
            $this->app->json(['success' => false, 'message' => 'Item not found'], 404);
            return;
        }

        $idReceveur = $itemDemande['idUser'];

        $demandeId = $demandModel->createDemande($currentUserId, $idReceveur, $idObjetOffert, $idObjetDemande, 1);

        if ($demandeId) {
            $this->app->json([
                'success' => true,
                'message' => 'Exchange request created',
                'demandeId' => $demandeId
            ], 201);
        } else {
            $this->app->json(['success' => false, 'message' => 'Failed to create exchange request'], 500);
        }
    }

    public function proceedExchange($id)
    {
        $pdo = $this->app->db();
        $demandeModel = new DemandeModel($pdo);
        $historiqueModel = new HistoriqueModel($pdo);
        $demandeId = $id;

        if (!$demandeId) {
            $this->app->json(['success' => false, 'message' => 'ID de demande manquant']);
            return;
        }

        $demande = $demandeModel->getDemandeById($demandeId);

        if (!$demande) {
            $this->app->json(['success' => false, 'message' => 'Demande introuvable']);
            return;
        }

        $result = $demandeModel->acceptDemande($demandeId);

        if ($result) {
            $echangeId = $historiqueModel->createEchange(
                $demande['idDemande'],
                $demande['idDemandeur'],
                $demande['idReceveur'],
                $demande['idObjetOffert'],
                $demande['idObjetDemande']
            );

            if ($echangeId) {
                // L'objet offert change de propriétaire (du demandeur vers le receveur)
                $historiqueModel->updateItemOwner($demande['idObjetOffert'], $demande['idReceveur']);

                // L'objet demandé change de propriétaire (du receveur vers le demandeur)
                $historiqueModel->updateItemOwner($demande['idObjetDemande'], $demande['idDemandeur']);
            }

            $this->app->json(['success' => true, 'message' => 'Demande acceptée avec succès']);
        } else {
            $this->app->json(['success' => false, 'message' => 'Erreur lors de l\'acceptation']);
        }
    }
}
