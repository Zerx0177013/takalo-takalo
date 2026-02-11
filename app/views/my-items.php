<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mes Objets - Takalo-Takalo</title>
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link rel="stylesheet" href="/assets/css/myItems.css">
</head>
<body>
    <div class="page-wrapper">
   <?php
   require_once("sidebar.php");
   ?>

        <div class="main-content">
            <div class="header">
                <h1>📦 Mes objets</h1>
                <p>Sélectionnez un objet pour le proposer en échange</p>
            </div>

            <div class="items-grid">
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <div class="item-card" id="item-<?php echo $item['idItem']; ?>" data-item-id="<?php echo $item['idItem']; ?>">
                            <button class="delete-btn" data-item-id="<?php echo $item['idItem']; ?>" title="Supprimer">
                                <i class="mdi mdi-close"></i>
                            </button>
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
                                    <button class="btn-primary btn-exchange" data-item-id="<?php echo $item['idItem']; ?>">Échanger</button>
                                    <button class="btn-secondary btn-details" data-item-id="<?php echo $item['idItem']; ?>">Détails</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="mdi mdi-package-variant-closed"></i>
                        <h2>Aucun objet</h2>
                        <p>Vous n'avez pas encore ajouté d'objets à proposer en échange.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listeners pour les boutons "Échanger"
            document.querySelectorAll('.btn-exchange').forEach(function(button) {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    window.location.href = '/propositions?itemId=' + itemId;
                });
            });

            // Event listeners pour les boutons "Détails"
            document.querySelectorAll('.btn-details').forEach(function(button) {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    window.location.href = '/items/' + itemId;
                });
            });

            // Event listeners pour les boutons de suppression
            document.querySelectorAll('.delete-btn').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.stopPropagation();
                    
                    const itemId = this.getAttribute('data-item-id');
                    
                    if (confirm('Êtes-vous sûr de vouloir supprimer cet objet ? Cette action est irréversible.')) {
                        fetch('/items/' + itemId, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Supprimer l'élément du DOM avec une animation
                                const itemCard = document.getElementById('item-' + itemId);
                                itemCard.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                                itemCard.style.opacity = '0';
                                itemCard.style.transform = 'scale(0.8)';
                                
                                setTimeout(() => {
                                    itemCard.remove();
                                    // Vérifier s'il reste des items
                                    const grid = document.querySelector('.items-grid');
                                    if (grid.children.length === 0) {
                                        location.reload();
                                    }
                                }, 300);
                            } else {
                                alert('Erreur lors de la suppression: ' + (data.message || 'Erreur inconnue'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Erreur lors de la suppression de l\'objet');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
