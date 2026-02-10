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
        .main-content {
            margin-left: 40px;
            padding: 35px 40px;
            flex: 1;
            min-height: 100vh;
        }
        .header {
            margin-bottom: 35px;
        }
        .header h1 {
            color: #2d3436;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 8px;
        }
        .header p {
            color: #636e72;
            font-size: 1rem;
        }
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 28px;
        }
        .item-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .item-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }
        .item-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .item-image i {
            font-size: 70px;
            opacity: 0.8;
        }
        .item-content {
            padding: 22px;
        }
        .item-name {
            font-size: 1.15rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .item-description {
            color: #636e72;
            font-size: 0.9rem;
            margin-bottom: 18px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 42px;
        }
        .item-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }
        .item-actions {
            display: flex;
            gap: 12px;
        }
        .item-actions button {
            flex: 1;
            padding: 12px 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #f0f0f0;
            color: #2d3436;
        }
        .btn-secondary:hover {
            background: #e0e0e0;
        }
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            grid-column: 1 / -1;
        }
        .empty-state i {
            font-size: 100px;
            color: #dfe6e9;
            margin-bottom: 25px;
            display: block;
        }
        .empty-state h2 {
            color: #636e72;
            margin-bottom: 12px;
            font-size: 1.5rem;
        }
        .empty-state p {
            color: #b2bec3;
            font-size: 1rem;
        }
        @media (max-width: 992px) {
            .sidebar-wrapper {
                width: 220px;
            }
            .main-content {
                margin-left: 220px;
            }
        }
        @media (max-width: 768px) {
            .sidebar-wrapper {
                width: 70px;
            }
            .sidebar-wrapper .nav-menu a span,
            .logout-btn span {
                display: none;
            }
            .main-content {
                margin-left: 70px;
            }
            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 20px;
            }
        }
    </style>
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
                                    <button class="btn-primary" onclick="selectItem(<?php echo $item['idItem']; ?>)">Échanger</button>
                                    <button class="btn-secondary">Détails</button>
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
        function selectItem(itemId) {
            // Rediriger vers la page propositions avec l'item sélectionné
            window.location.href = '/propositions?itemId=' + itemId;
        }
    </script>
</body>
</html>
