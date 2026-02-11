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

    public function getAllItemsExceptSelf(): array
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);
        $currentUserId = $_SESSION['idUser'];

        $items = $model->getAllItemsExceptSelf($currentUserId);

        // Charger la première image de chaque item
        foreach ($items as &$item) {
            $image = $model->getFirstImageOfAnItem($item['idItem']);
            $item['image'] = $image ? $image['imageURL'] : null;
        }

        return $items;
    }

    public function getItemById(int $id)
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);
        $item = $model->getItemById($id);
        
        if (!$item) {
            $this->app->redirect('/');
            return;
        }
        
        $images = $model->getAllImagesOfAnItem($id);
        
        $this->app->render('item-details', [
            'item' => $item,
            'images' => $images,
            'currentUserId' => $_SESSION['idUser'] ?? null
        ]);
    }

    public function deleteItem($id)
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);
        $demandModel = new DemandeModel($pdo);

        // Vérifier que l'item appartient à l'utilisateur actuel
        $item = $model->getItemById($id);
        if (!$item || $item['idUser'] !== $_SESSION['idUser']) {
            $this->app->json(['success' => false, 'message' => 'Unauthorized'], 403);
            return;
        }

        try {
            // Supprimer les demandes liées à cet item
            $demandModel->deleteDemandsByItemId($id);

            // Supprimer les images liées à cet item
            $model->deleteImagesByItemId($id);

            // Supprimer l'item lui-même
            $deleted = $model->deleteItemById($id);

            if ($deleted) {
                $this->app->json(['success' => true, 'message' => 'Item deleted successfully']);
            } else {
                $this->app->json(['success' => false, 'message' => 'Failed to delete item'], 500);
            }
        } catch (\Exception $e) {
            $this->app->json(['success' => false, 'message' => 'Error deleting item'], 500);
        }
    }

    public function index()
    {
        $items = $this->getAllItemsExceptSelf();
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

        $imageFile = $this->app->request()->files['imageURL'] ?? null;

        $imageUrls = [];

        // Handle file upload (single or multiple)
        if ($imageFile) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/assets/images/items/';
            $uploadUrl = BASE_URL . '/assets/images/items/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Check if multiple files were uploaded
            if (is_array($imageFile['name'])) {
                // Multiple files
                $fileCount = count($imageFile['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($imageFile['error'][$i] === UPLOAD_ERR_OK) {
                        $extension = pathinfo($imageFile['name'][$i], PATHINFO_EXTENSION);
                        $filename = uniqid('item_') . '.' . $extension;
                        $destination = $uploadDir . $filename;

                        if (move_uploaded_file($imageFile['tmp_name'][$i], $destination)) {
                            $imageUrls[] = $uploadUrl . $filename;
                        }
                    }
                }
            } else {
                // Single file
                if ($imageFile['error'] === UPLOAD_ERR_OK) {
                    $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                    $filename = uniqid('item_') . '.' . $extension;
                    $destination = $uploadDir . $filename;

                    if (move_uploaded_file($imageFile['tmp_name'], $destination)) {
                        $imageUrls[] = $uploadUrl . $filename;
                    }
                }
            }
        }

        $itemId = $model->createItem($name, $desc, $price, $idcategorie, $currentUserId, $imageUrls);

        if ($itemId) {
            $this->app->redirect('/my-items');
        } else {
            $this->app->redirect('/items/new?error=creation_failed');
        }
    }
}
