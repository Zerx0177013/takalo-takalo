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
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="header">
                    <div class="header-text">
                        <h1>🏷️ Historique d'echanges</h1>
                        <p>Voyez ici les echanges passes de cet objet</p>
                    </div>

                </div>

                <div class="categories-card">
                    <?php if (empty($historique)): ?>
                        <div class="empty-state">
                            <i class="mdi mdi-tag-off-outline"></i>
                            <p>Aucune catégorie trouvée</p>
                        </div>
                    <?php else: ?>
                        <table class="categories-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date echange </th>
                                    <th>ancien proprietaire</th>
                                    <th>nouveau proprietaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historique as $entry): ?>
                                    <tr>
                                        <td class="category-id">
                                            #<?= htmlspecialchars((string) ($entry['idItem'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                        </td>
                                        <td class="category-name">
                                            <?= htmlspecialchars((string) ($entry['dateEchange'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                        </td>
                                        <td class="category-name">
                                            <?= htmlspecialchars((string) ($entry['ancien_proprietaire'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                        </td>
                                        <td class="category-name">
                                            <?= htmlspecialchars((string) ($entry['nouveau_proprietaire'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
            <!-- end content-wrapper -->

            <?php
            require_once("footer.php");
            ?>
        </div>
    </div>

    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>

</body>

</html>