<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\DemandeModel;
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

        $demandes = $model->getAllDemandeFromMyself($currentUserId);

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

        $demandes = $model->getAllDemandeToMyself($currentUserId);

        $this->app->render('mes-demandes', ['demandes' => $demandes]);
    }
}
