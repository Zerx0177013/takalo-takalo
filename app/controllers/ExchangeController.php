<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\ItemModel;
use app\models\DemandeModel;
use app\models\HistoriqueModel;
use app\models\EchangeModel;


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

        // Validate user session
        if (!isset($_SESSION['idUser'])) {
            $this->app->json(['success' => false, 'message' => 'User not authenticated'], 401);
            return;
        }

        $currentUserId = $_SESSION['idUser'];

        // Get and validate request data
        $idObjetOffert = $this->app->request()->data->idObjetOffert ?? null;
        $idObjetDemande = $this->app->request()->data->idObjetDemande ?? null;

        if (!$idObjetOffert || !$idObjetDemande) {
            $this->app->json(['success' => false, 'message' => 'Missing required parameters'], 400);
            return;
        }

        // Validate offered item exists and belongs to current user
        $itemOffert = $itemModel->getItemById($idObjetOffert);
        if (!$itemOffert) {
            $this->app->json(['success' => false, 'message' => 'Offered item not found'], 404);
            return;
        }

        if ($itemOffert['idUser'] !== $currentUserId) {
            $this->app->json(['success' => false, 'message' => 'You do not own the offered item'], 403);
            return;
        }

        // Validate requested item exists
        $itemDemande = $itemModel->getItemById($idObjetDemande);
        if (!$itemDemande) {
            $this->app->json(['success' => false, 'message' => 'Requested item not found'], 404);
            return;
        }

        $idReceveur = $itemDemande['idUser'];

        // Prevent self-exchange
        if ($currentUserId === $idReceveur) {
            $this->app->json(['success' => false, 'message' => 'You cannot exchange with yourself'], 400);
            return;
        }

        // Create exchange request
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
            $demandeModel->invalidateDemandeForItem($demande['idObjetOffert']);
            $demandeModel->invalidateDemandeForItem($demande['idObjetDemande']);
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

    public function getNombreEchangeReussi()
    {
        $pdo = $this->app->db();
        $historiqueModel = new EchangeModel($pdo);
        $currentUserId = $_SESSION['idUser'] ?? null;

        if (!$currentUserId) {
            $this->app->json(['success' => false, 'message' => 'User not authenticated'], 401);
            return;
        }

        $nombreEchanges = $historiqueModel->getNombreEchangeReussi();

        return $nombreEchanges;
        // $this->app->json(['success' => true, 'nombreEchanges' => $nombreEchanges]);
        // $this->app->render('dashboard', ['nombreEchanges' => $nombreEchanges]);
    }
}
