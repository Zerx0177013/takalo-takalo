<?php

use Tracy\Bar;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Propositions d'échange - Takalo-Takalo</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link rel="stylesheet" href="/assets/css/index.css"></head>
<body>
    <div class="page-wrapper">
        <!-- Sidebar -->
    <?php
   require_once("sidebar.php");
   ?>


        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>💱 Propositions d'échange</h1>
                <p>Tous les objets disponibles pour l'échange</p>
            </div>

            <div class="filter-section" style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="/propositions?itemId=<?php echo $selectedItem['idItem']; ?>" class="btn btn-gradient-light" style="padding: 8px 16px; text-decoration: none;">Tous</a>
                <a href="/propositions?itemId=<?php echo $selectedItem['idItem']; ?>&range=10" class="btn btn-gradient-secondary" style="padding: 8px 16px; text-decoration: none;">±10%</a>
                <a href="/propositions?itemId=<?php echo $selectedItem['idItem']; ?>&range=20" class="btn btn-gradient-secondary" style="padding: 8px 16px; text-decoration: none;">±20%</a>
            </div>

            <div class="items-grid">
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <div class="item-card">
                            <div class="item-image">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                <?php else: ?>
                                    <i class="mdi mdi-package-variant"></i>
                                <?php endif; ?>
                            </div>
                            <div class="item-content">
                                <h3 class="item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                <p class="item-description">
                                    <?php 
                                        $description = $item['description'] ?? 'Aucune description disponible.';
                                        echo htmlspecialchars($description);
                                    ?>
                                </p>
                                <?php if (!empty($item['price'])): ?>
                                    <div class="item-price"><?php echo number_format($item['price'], 2, ',', ' '); ?> Ar
                                        <?php if ($item['differencePourcentage'] !== null): ?>
                                            <span style="margin-left: 10px; font-size: 0.9em; <?php echo ($item['differencePourcentage'] > 0) ? 'color: #ff6b6b;' : 'color: #51cf66;'; ?>">
                                                <?php echo ($item['differencePourcentage'] > 0) ? '+' : ''; ?><?php echo number_format($item['differencePourcentage'], 1, ',', ' '); ?>%
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="item-actions">
                                    <button class="btn btn-gradient-primary btn-lg" onclick="confirmExchange(<?php echo $selectedItem['idItem']; ?>, <?php echo $item['idItem']; ?>, '<?php echo htmlspecialchars($selectedItem['name']); ?>', '<?php echo htmlspecialchars($item['name']); ?>')">
                                        <i class="mdi mdi-swap-horizontal"></i> Échanger
                                    </button>
                                    <button class="btn btn-gradient-light btn-lg" onclick="window.location.href='/items/<?php echo $item['idItem']; ?>'">
                                        <i class="mdi mdi-eye"></i> Détails
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="mdi mdi-package-variant-closed"></i>
                        <h2>Aucune proposition disponible</h2>
                        <p>Il n'y a actuellement aucune proposition d'échange disponible.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <!-- endinject -->

    <!-- Exchange Modal -->
    <div id="exchangeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>💱 Confirmer l'échange</h2>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir proposer cet échange ?</p>
                <div class="modal-info">
                    <div class="modal-info-item">
                        <span class="modal-info-label">Vous offrez:</span>
                        <span class="modal-info-value" id="modalOfferedItem">-</span>
                    </div>
                    <div class="modal-info-item">
                        <span class="modal-info-label">Vous demandez:</span>
                        <span class="modal-info-value" id="modalRequestedItem">-</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-confirm" onclick="submitExchange()">Confirmer</button>
                <button class="modal-btn modal-btn-cancel" onclick="closeModal()">Annuler</button>
            </div>
        </div>
    </div>

  <script src="/assets/js/propositions.js"></script>
</body>
</html>
