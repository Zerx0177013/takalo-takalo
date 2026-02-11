<?php

use Tracy\Bar;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Takalo-Takalo - Home</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <div class="page-wrapper">
        <!-- Sidebar -->
<?php
require_once("sidebar.php") ;
?>
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>📦 Objets disponibles</h1>
                <p>Découvrez les objets disponibles pour l'échange</p>
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
                                    <div class="item-price"><?php echo number_format($item['price'], 2, ',', ' '); ?> Ar</div>
                                <?php endif; ?>
                                <div class="item-actions">
                                    <button class="btn-primary" onclick="window.location.href='/items/<?php echo $item['idItem']; ?>'">Voir détails</button>
                                    <button class="btn-secondary" onclick="window.location.href='/propositions?itemId=<?php echo $item['idItem']; ?>'">Échanger</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="mdi mdi-package-variant-closed"></i>
                        <h2>Aucun objet disponible</h2>
                        <p>Il n'y a actuellement aucun objet disponible pour l'échange.</p>
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
</body>
</html>
