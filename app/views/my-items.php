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

            <div class="filter-bar" style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
                    <div style="flex: 1; min-width: 250px;">
                        <label style="font-size: 14px; color: #666; font-weight: 600; margin-bottom: 8px; display: block;">
                            <i class="mdi mdi-magnify"></i> Rechercher
                        </label>
                        <input type="text" id="searchInput" placeholder="Rechercher par nom ou description..." 
                               style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                    </div>
                    <div style="flex: 0 0 200px;">
                        <label style="font-size: 14px; color: #666; font-weight: 600; margin-bottom: 8px; display: block;">
                            <i class="mdi mdi-tag"></i> Catégorie
                        </label>
                        <select id="categoryFilter" style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; cursor: pointer;">
                            <option value="all">Toutes les catégories</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['idcategorie']); ?>">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="items-grid">
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <div class="item-card" 
                             id="item-<?php echo $item['idItem']; ?>" 
                             data-item-id="<?php echo $item['idItem']; ?>"
                             data-category="<?php echo htmlspecialchars($item['idcategorie'] ?? ''); ?>" 
                             data-name="<?php echo strtolower(htmlspecialchars($item['name'])); ?>" 
                             data-description="<?php echo strtolower(htmlspecialchars($item['description'] ?? '')); ?>">
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
                                    <button class="btn btn-gradient-primary btn-lg btn-exchange" data-item-id="<?php echo $item['idItem']; ?>">
                                        <i class="mdi mdi-swap-horizontal"></i> Échanger
                                    </button>
                                    <button class="btn btn-gradient-light btn-lg btn-details" data-item-id="<?php echo $item['idItem']; ?>">
                                        <i class="mdi mdi-eye"></i> Détails
                                    </button>
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
            
            // Filtrage des items
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const itemCards = document.querySelectorAll('.item-card');
            
            function filterItems() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value;
                
                itemCards.forEach(function(card) {
                    const itemName = card.getAttribute('data-name');
                    const itemDescription = card.getAttribute('data-description');
                    const itemCategory = card.getAttribute('data-category');
                    
                    const matchesSearch = itemName.includes(searchTerm) || itemDescription.includes(searchTerm);
                    const matchesCategory = selectedCategory === 'all' || itemCategory === selectedCategory;
                    
                    if (matchesSearch && matchesCategory) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
            
            searchInput.addEventListener('input', filterItems);
            categoryFilter.addEventListener('change', filterItems);
        });
    </script>
</body>
</html>
