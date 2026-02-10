<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Takalo-Takalo - Catégories</title>
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
	<link rel="stylesheet" href="/assets/css/category.css">
</head>

<body>
    <div class="page-wrapper">
        <!-- Sidebar -->
   <?php
	require_once 'sidebar.php';
   ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="header-text">
                    <h1>🏷️ Catégories</h1>
                    <p>Gérez les catégories d'objets disponibles sur la plateforme</p>
                </div>
                <a href="/categories/new" class="btn-add">
                    <i class="mdi mdi-plus"></i>
                    Ajouter une catégorie
                </a>
            </div>

            <div class="categories-card">
                <?php if (empty($categories)): ?>
                    <div class="empty-state">
                        <i class="mdi mdi-tag-off-outline"></i>
                        <p>Aucune catégorie trouvée</p>
                    </div>
                <?php else: ?>
                    <table class="categories-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom de la catégorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td class="category-id">#<?= htmlspecialchars((string) ($category['idcategorie'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="category-name"><?= htmlspecialchars((string) ($category['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="actions-cell">
                                        <a href="/categories/<?= htmlspecialchars((string) ($category['idcategorie'] ?? ''), ENT_QUOTES, 'UTF-8') ?>/edit" class="btn-action btn-edit">
                                            <i class="mdi mdi-pencil"></i>
                                            <span>Modifier</span>
                                        </a>
                                        <button type="button" class="btn-action btn-delete" onclick="deleteCategory(<?= (int)($category['idcategorie'] ?? 0) ?>)">
                                            <i class="mdi mdi-delete"></i>
                                            <span>Supprimer</span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    
    <script>
        function deleteCategory(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
                fetch('/categories/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                })
                .catch(error => {
                    alert('Erreur lors de la suppression');
                });
            }
        }
    </script>
</body>

</html>
