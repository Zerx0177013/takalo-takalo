<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\ItemModel;
use flight\Engine;

class ItemController
{
    protected Engine $app;

    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    /**
     * Récupère tous les items avec leur première image
     */
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

    /**
     * Récupère un item par son ID
     */
    public function getItemById(int $id): ?array
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);
        return $model->getItemById($id);
    }

    /**
     * Affiche la page d'accueil avec tous les items
     */
    public function index()
    {
        $items = $this->getAllItems();
        $this->app->render('index', ['items' => $items]);
    }

    /**
     * Affiche la liste des propositions d'échange avec filtrage par prix
     * ?itemId=1&range=5 - affiche les items avec prix dans la plage de l'item spécifié ±5
     */
    public function propositions()
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);
        
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
            'range' => $range
        ]);
    }
}
