<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\ItemModel;
use app\models\DemandModel;
use flight\Engine;

class ItemController
{
    protected Engine $app;
    
    // Hardcoded user ID (comment out session usage)
    private const CURRENT_USER_ID = 1; // TODO: Replace with $_SESSION['idUser'] when session is available

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
     * Affiche la liste de mes items (items de l'utilisateur connecté)
     * Pour sélectionner un item à échanger
     */
    public function myItems()
    {
        $pdo = $this->app->db();
        $model = new ItemModel($pdo);
        
        // Hardcoded user ID
        // TODO: Use $_SESSION['idUser'] when session is available
        $userId = self::CURRENT_USER_ID;
        
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
        
        // Hardcoded user ID
        // TODO: Use $_SESSION['idUser'] when session is available
        $currentUserId = self::CURRENT_USER_ID;
        
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

    /**
     * Crée une demande d'échange
     * POST /exchange avec: idObjetOffert, idObjetDemande
     */
    public function createExchange()
    {
        $pdo = $this->app->db();
        $demandModel = new DemandModel($pdo);
        $itemModel = new ItemModel($pdo);
        
        // Hardcoded user ID
        // TODO: Use $_SESSION['idUser'] when session is available
        $currentUserId = self::CURRENT_USER_ID;
        
        $idObjetOffert = $this->app->request()->data->idObjetOffert;
        $idObjetDemande = $this->app->request()->data->idObjetDemande;
        
        // Récupérer l'item demandé pour connaître le propriétaire (idReceveur)
        $itemDemande = $itemModel->getItemById($idObjetDemande);
        
        if (!$itemDemande) {
            $this->app->json(['success' => false, 'message' => 'Item not found'], 404);
            return;
        }
        
        $idReceveur = $itemDemande['idUser'];
        
        // Créer la demande d'échange
        $demandeId = $demandModel->createDemande($currentUserId, $idReceveur, $idObjetOffert, $idObjetDemande);
        
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
}
