<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\AuthModel;
use app\models\ItemModel;
use app\models\DemandeModel;
use app\models\CategoryModel;

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
        $authModel = new AuthModel($this->app->db());
        if($authModel->isLoggedIn() === false) return [] ;
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
            $categoryModel = new CategoryModel($pdo);
            $selectedItem = $model->getItemById($itemId);
            $exits = $categoryModel->categoryExists($selectedItem['idcategorie']);
            
            if ($selectedItem && $selectedItem['price'] && $exits) {
                // Déterminer si on affiche les items du user ou des autres
                if ($selectedItem['idUser'] === $currentUserId) {
                    // L'item sélectionné appartient au user → afficher les items des AUTRES (ce qu'il peut recevoir)
                    $items = $model->getItemsByReferencePrice($selectedItem['price'], $range, $currentUserId);
                } else {
                    // L'item sélectionné appartient à quelqu'un d'autre → afficher les items DU USER (ce qu'il peut offrir)
                    $items = $model->getItemsByReferencePriceOthers($selectedItem['price'], $range, $currentUserId);
                    // Exclure l'item sélectionné s'il apparaît dans la liste
                    $items = array_filter($items, function($item) use ($itemId) {
                        return $item['idItem'] != $itemId;
                    });
                }
            } else {
                $items = $this->getAllItemsExceptSelf();
            }
        } else {
            // Sinon afficher tous les items
            $items = $this->getAllItemsExceptSelf();
        }

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
