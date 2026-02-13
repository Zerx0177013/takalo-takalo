<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\ItemModel;
use app\models\DemandeModel;
use app\models\UserModel;
use app\models\EchangeModel;


use flight\Engine;

class StatController
{
    protected Engine $app;
    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    public function getInformationOverall(){
        $pdo = $this->app->db();
        $userModel = new UserModel($pdo);
        $exchangeModel = new EchangeModel($pdo);

        $numberOfUsers = $userModel->getNumberOfUsers();
        $numberOfExchanges = $exchangeModel->getNombreEchangeReussi();

        // return [
        //     'numberOfUsers' => $numberOfUsers,
        //     'numberOfExchanges' => $numberOfExchanges
        // ];
        $this->app->render('dashboard', [
            'numberOfUsers' => $numberOfUsers,
            'numberOfExchanges' => $numberOfExchanges
        ]);
    }

}
