<?php

namespace app\controllers;

use app\models\AuthModel;
use app\models\HistoriqueModel;
use app\models\ItemModel;
use app\models\UserModel;
use app\models\DemandeModel;

use flight\Engine;

use Flight;

class HistoriqueController
{

    protected Engine $app;
    public function __construct(Engine $app)
    {
        $this->app = $app;
    }
    public function getHistoriqueByID($itemId)
    {
        $ItemModel = new ItemModel($this->app->db());
        if ($ItemModel->getItemById($itemId) == null) {
            return null;
        }
        $HistoriqueModel = new HistoriqueModel($this->app->db());
        $val = $HistoriqueModel->getHistoriqueObjet($itemId);
        return $val;
    }
}