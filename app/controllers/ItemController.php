<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\ItemModel;
use app\models\DemandeModel;
use flight\Engine;

class ItemController
{
    protected Engine $app;
    public function __construct(Engine $app)
    {
        $this->app = $app;
    }
    public function getAllItems(): array
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);
        $items = $model->getAllItems();

        // Charger la première image de chaque item
        foreach ($items as &$item) {
            $image = $model->getFirstImageOfAnItem($item['idItem']);
            $item['image'] = $image ? $image['imageURL'] : null;
        }

        return $items;
    }

    public function getItemById(int $id): ?array
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);
        return $model->getItemById($id);
    }

    public function index()
    {
        $items = $this->getAllItems();
        $this->app->render('index', ['items' => $items]);
    }

    public function myItems()
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);

        $userId = $_SESSION['idUser'];

        $items = $model->getItemsByUserId($userId);

        // Charger la première image de chaque item
        foreach ($items as &$item) {
            $image = $model->getFirstImageOfAnItem($item['idItem']);
            $item['image'] = $image ? $image['imageURL'] : null;
        }

        $this->app->render('my-items', [
            'items' => $items,
            'currentUserId' => $userId
        ]);
    }

    /**
     * Affiche la liste des propositions d'échange pour l'item sélectionné
     * ?itemId=1 - affiche les items avec prix dans la plage de l'item spécifié
     */
    public function propositions()
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);


        $currentUserId = $_SESSION['idUser'];

        $itemId = $this->app->request()->query['itemId'] ?? null;
        $range = (int) ($this->app->request()->query['range'] ?? 5);

        $items = [];
        $selectedItem = null;

        if ($itemId) {
            // Si un item ID est spécifié, charger cet item et filtrer par sa plage de prix
            $selectedItem = $model->getItemById($itemId);
            if ($selectedItem && $selectedItem['price']) {
                $items = $model->getItemsByReferencePrice($selectedItem['price'], $range);
            } else {
                $items = $this->getAllItems();
            }
        } else {
            // Sinon afficher tous les items
            $items = $this->getAllItems();
        }

        // Charger la première image pour chaque item
        foreach ($items as &$item) {
            $image = $model->getFirstImageOfAnItem($item['idItem']);
            $item['image'] = $image ? $image['imageURL'] : null;
        }

        $this->app->render('propositions', [
            'items' => $items,
            'selectedItem' => $selectedItem,
            'range' => $range,
            'currentUserId' => $currentUserId
        ]);
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

    public function createItem()
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);

        $currentUserId = $_SESSION['idUser'];
        $name = $this->app->request()->data->name;           
        $desc = $this->app->request()->data->description; 
        $idcategorie = $this->app->request()->data->idcategorie; 
        $price = $this->app->request()->data->price;      
        $imageFile = $this->app->request()->files['imageURL']; 

        $model->createItem($name, $desc, $price, $idcategorie, $currentUserId, [$imageFile]);

        $this->app->json(['success' => true, 'message' => 'Item created successfully']);
    }
}
