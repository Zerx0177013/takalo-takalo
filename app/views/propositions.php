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
   
        /* Main Content */
        .main-content {
            margin-left: 260px;
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
        /* Items Grid */
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
        /* Empty State */
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
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            animation: slideUp 0.3s ease;
        }
        .modal-header {
            margin-bottom: 25px;
        }
        .modal-header h2 {
            color: #2d3436;
            font-size: 1.8rem;
            margin: 0;
        }
        .modal-body {
            margin-bottom: 30px;
            color: #636e72;
            line-height: 1.6;
        }
        .modal-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .modal-info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .modal-info-item:last-child {
            border-bottom: none;
        }
        .modal-info-label {
            font-weight: 600;
            color: #2d3436;
        }
        .modal-info-value {
            color: #636e72;
        }
        .modal-footer {
            display: flex;
            gap: 12px;
        }
        .modal-btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .modal-btn-confirm {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .modal-btn-cancel {
            background: #f0f0f0;
            color: #2d3436;
        }
        .modal-btn-cancel:hover {
            background: #e0e0e0;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar-wrapper {
                width: 220px;
                padding: 20px 15px;
            }
            .main-content {
                margin-left: 40px;
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
            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 20px;
            }
        }
    </style>
</head>
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
                                    <button class="btn-primary" onclick="confirmExchange(<?php echo $selectedItem['idItem']; ?>, <?php echo $item['idItem']; ?>, '<?php echo htmlspecialchars($selectedItem['name']); ?>', '<?php echo htmlspecialchars($item['name']); ?>')">Échanger</button>
                                    <button class="btn-secondary">Détails</button>
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

    <script>
        let selectedItemId = null;
        let proposedItemId = null;
        let selectedItemName = null;
        let proposedItemName = null;

        function confirmExchange(offeredItemId, requestedItemId, offeredItemName, requestedItemName) {
            selectedItemId = offeredItemId;
            proposedItemId = requestedItemId;
            selectedItemName = offeredItemName;
            proposedItemName = requestedItemName;
            
            document.getElementById('modalOfferedItem').textContent = offeredItemName;
            document.getElementById('modalRequestedItem').textContent = requestedItemName;
            
            document.getElementById('exchangeModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('exchangeModal').classList.remove('show');
        }

        function submitExchange() {
            // Send POST request to create exchange
            fetch('/exchange', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    idObjetOffert: selectedItemId,
                    idObjetDemande: proposedItemId
                })
            })
            .then(response => response.json())
            .then(data => {
                closeModal();
                if (data.success) {
                    alert('✅ Demande d\'échange créée avec succès!');
                    // Redirect to my-items or show success page
                    setTimeout(() => {
                        window.location.href = '/my-items';
                    }, 1500);
                } else {
                    alert('❌ Erreur: ' + (data.message || 'Impossible de créer la demande'));
                }
            })
            .catch(error => {
                closeModal();
                console.error('Error:', error);
                alert('❌ Une erreur est survenue');
            });
        }

        // Close modal when clicking outside
        document.getElementById('exchangeModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
