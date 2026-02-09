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
}
