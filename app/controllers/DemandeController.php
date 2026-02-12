<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\DemandeModel;
use app\models\HistoriqueModel;
use flight\Engine;

class DemandeController
{
    protected Engine $app;

    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    public function mesdemandes()
    {
        $pdo = $this->app->db();
        $model = new DemandeModel($pdo);
        $currentUserId = $_SESSION['idUser'] ?? null;

        if (!$currentUserId) {
            $this->app->redirect('/login');
            return;
        }

        $demandes = $model->getAllDemandeFromMyselfWithDetails($currentUserId);

        $this->app->render('mes-demandes', ['demandes' => $demandes]);
    }

    public function othersdemandes()
    {
        $pdo = $this->app->db();
        $model = new DemandeModel($pdo);
        $currentUserId = $_SESSION['idUser'] ?? null;

        if (!$currentUserId) {
            $this->app->redirect('/login');
            return;
        }

        $demandes = $model->getAllDemandeToMyselfWithDetails($currentUserId);

        $this->app->render('other-demandes', ['demandes' => $demandes]);
    }

   

    public function refuseDemande($id)
    {
        $pdo = $this->app->db();
        $model = new DemandeModel($pdo);
        $demandeId = $id;

        if (!$demandeId) {
            $this->app->json(['success' => false, 'message' => 'ID de demande manquant']);
            return;
        }

        $result = $model->refuseDemande($demandeId);

        if ($result) {
            $this->app->json(['success' => true, 'message' => 'Demande refusée']);
        } else {
            $this->app->json(['success' => false, 'message' => 'Erreur lors du refus']);
        }
    }
}
