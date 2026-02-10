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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f4f5f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar-wrapper {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar-wrapper .logo {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-wrapper .logo img {
            height: 55px;
            width: auto;
            filter: brightness(0) invert(1);
        }

        .sidebar-wrapper .nav-menu {
            list-style: none;
            flex: 1;
        }

        .sidebar-wrapper .nav-menu li {
            margin-bottom: 8px;
        }

        .sidebar-wrapper .nav-menu a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 14px 18px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .sidebar-wrapper .nav-menu a:hover,
        .sidebar-wrapper .nav-menu a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-wrapper .nav-menu i {
            margin-right: 12px;
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .logout-section {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .logout-btn {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
            color: white;
            border: none;
            padding: 14px 18px;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(238, 90, 90, 0.3);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #ee5a5a 0%, #dc4747 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(238, 90, 90, 0.4);
        }

        .logout-btn i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 35px 40px;
            flex: 1;
            min-height: 100vh;
        }

        .header {
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-text h1 {
            color: #2d3436;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .header-text p {
            color: #636e72;
            font-size: 1rem;
        }

        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Categories Table */
        .categories-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .categories-table {
            width: 100%;
            border-collapse: collapse;
        }

        .categories-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 24px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .categories-table th:last-child {
            text-align: center;
        }

        .categories-table td {
            padding: 18px 24px;
            border-bottom: 1px solid #f0f0f0;
            color: #2d3436;
            font-size: 0.95rem;
        }

        .categories-table tr:last-child td {
            border-bottom: none;
        }

        .categories-table tr:hover {
            background: #f8f9ff;
        }

        .category-id {
            font-weight: 600;
            color: #667eea;
            width: 80px;
        }

        .category-name {
            font-weight: 500;
        }

        .actions-cell {
            text-align: center;
            white-space: nowrap;
        }

        .btn-action {
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            margin: 0 4px;
        }

        .btn-edit {
            background: #f0f7ff;
            color: #3498db;
        }

        .btn-edit:hover {
            background: #3498db;
            color: white;
        }

        .btn-delete {
            background: #fff0f0;
            color: #e74c3c;
        }

        .btn-delete:hover {
            background: #e74c3c;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #636e72;
        }

        .empty-state i {
            font-size: 80px;
            color: #dfe6e9;
            margin-bottom: 20px;
            display: block;
        }

        .empty-state p {
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar-wrapper {
                width: 220px;
                padding: 20px 15px;
            }

            .main-content {
                margin-left: 220px;
                padding: 25px 30px;
            }
        }

        @media (max-width: 768px) {
            .sidebar-wrapper {
                width: 70px;
                padding: 15px 10px;
            }

            .sidebar-wrapper .logo img {
                height: 35px;
            }

            .sidebar-wrapper .nav-menu a span,
            .logout-btn span {
                display: none;
            }

            .sidebar-wrapper .nav-menu a {
                justify-content: center;
                padding: 14px;
            }

            .sidebar-wrapper .nav-menu i {
                margin-right: 0;
            }

            .logout-btn {
                padding: 14px;
            }

            .logout-btn i {
                margin-right: 0;
            }

            .main-content {
                margin-left: 70px;
                padding: 20px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .btn-action span {
                display: none;
            }

            .categories-table th,
            .categories-table td {
                padding: 14px 16px;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            <div class="logo">
                <img src="/assets/images/logo.png" alt="Takalo-Takalo">
            </div>

            <ul class="nav-menu">
                <li>
                    <a href="/">
                        <i class="mdi mdi-home-outline"></i>
                        <span>Accueil</span>
                    </a>
                </li>
                <li>
                    <a href="/items/new">
                        <i class="mdi mdi-plus-circle-outline"></i>
                        <span>Ajouter un objet</span>
                    </a>
                </li>
                <li>
                    <a href="/categories" class="active">
                        <i class="mdi mdi-tag-multiple-outline"></i>
                        <span>Catégories</span>
                    </a>
                </li>
                <li>
                    <a href="#" title="Non implémenté">
                        <i class="mdi mdi-swap-horizontal"></i>
                        <span>Mes échanges</span>
                    </a>
                </li>
                <li>
                    <a href="#" title="Non implémenté">
                        <i class="mdi mdi-heart-outline"></i>
                        <span>Favoris</span>
                    </a>
                </li>
                <li>
                    <a href="#" title="Non implémenté">
                        <i class="mdi mdi-account-outline"></i>
                        <span>Mon profil</span>
                    </a>
                </li>
            </ul>

            <div class="logout-section">
                <button class="logout-btn" onclick="window.location.href='/logout'" title="Se déconnecter">
                    <i class="mdi mdi-logout"></i>
                    <span>Déconnexion</span>
                </button>
            </div>
        </div>

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
