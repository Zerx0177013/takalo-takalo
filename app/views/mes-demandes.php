<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mes Demandes - Takalo-Takalo</title>
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link rel="stylesheet" href="/assets/css/myItems.css">
    <style>
        .demande-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 15px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .demande-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .demande-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .demande-id {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }
        .demande-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-accepted {
            background-color: #d4edda;
            color: #155724;
        }
        .status-refused {
            background-color: #f8d7da;
            color: #721c24;
        }
        .demande-body {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .demande-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .demande-info label {
            font-size: 12px;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
        }
        .demande-info span {
            font-size: 14px;
            color: #333;
        }

                .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 8px 20px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #666;
        }
        .filter-btn:hover {
            border-color: #667eea;
            color: #667eea;
        }
        .filter-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
        }
        .filter-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
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
                <h1>📬 Mes demandes d'échange</h1>
                <p>Consultez toutes les demandes d'échange que vous avez initiées</p>
            </div>

            <div class="filter-bar">
                <label class="filter-label">
                    <i class="mdi mdi-filter"></i> Filtrer par statut
                </label>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">
                        <i class="mdi mdi-all-inclusive"></i> Toutes
                    </button>
                    <button class="filter-btn" data-filter="pending">
                        <i class="mdi mdi-clock-outline"></i> En attente
                    </button>
                    <button class="filter-btn" data-filter="accepted">
                        <i class="mdi mdi-check-circle"></i> Acceptées
                    </button>
                    <button class="filter-btn" data-filter="refused">
                        <i class="mdi mdi-close-circle"></i> Refusées
                    </button>
                </div>
            </div>

            <div class="demandes-container">
                <?php if (!empty($demandes)) { ?>
                    <?php foreach ($demandes as $demande) { ?>
                        <div class="demande-card" data-status="<?php 
                            $statusId = $demande['idDemandeStatus'] ?? 1;
                            if ($statusId == 2) {
                                echo 'accepted';
                            } elseif ($statusId == 3) {
                                echo 'refused';
                            } else {
                                echo 'pending';
                            }
                        ?>">
                            <div class="demande-header">
                                <div class="demande-id">
                                    <i class="mdi mdi-swap-horizontal"></i>
                                    Demande #<?php echo htmlspecialchars($demande['idDemande']); ?>
                                </div>
                                <div class="demande-status <?php 
                                    $statusId = $demande['idDemandeStatus'] ?? 1;
                                    if ($statusId == 2) {
                                        echo 'status-accepted';
                                    } elseif ($statusId == 3) {
                                        echo 'status-refused';
                                    } else {
                                        echo 'status-pending';
                                    }
                                ?>">
                                    <?php 
                                        $statusId = $demande['idDemandeStatus'] ?? 1;
                                        if ($statusId == 2) {
                                            echo '✓ Acceptée';
                                        } elseif ($statusId == 3) {
                                            echo '✗ Refusée';
                                        } else {
                                            echo '⏳ En attente';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="demande-body">
                                <div class="demande-info">
                                    <label><i class="mdi mdi-account"></i> Demandeur</label>
                                    <span><?php echo htmlspecialchars($demande['demandeur_username']); ?></span>
                                </div>
                                <div class="demande-info">
                                    <label><i class="mdi mdi-account-check"></i> Receveur</label>
                                    <span><?php echo htmlspecialchars($demande['receveur_username']); ?></span>
                                </div>
                                <div class="demande-info">
                                    <label><i class="mdi mdi-package-variant"></i> Objet offert</label>
                                    <span><?php echo htmlspecialchars($demande['objet_offert_name']); ?></span>
                                </div>
                                <div class="demande-info">
                                    <label><i class="mdi mdi-package-variant-closed"></i> Objet demandé</label>
                                    <span><?php echo htmlspecialchars($demande['objet_demande_name']); ?></span>
                                </div>
                                <?php if (!empty($demande['createdAt'])) { ?>
                                <div class="demande-info">
                                    <label><i class="mdi mdi-calendar"></i> Date de création</label>
                                    <span><?php echo date('d/m/Y H:i', strtotime($demande['createdAt'])); ?></span>
                                </div>
                                <?php } ?>
                                <?php if (!empty($demande['statusAt'])) { ?>
                                <div class="demande-info">
                                    <label><i class="mdi mdi-update"></i> Dernière mise à jour</label>
                                    <span><?php echo date('d/m/Y H:i', strtotime($demande['statusAt'])); ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="empty-state">
                        <i class="mdi mdi-email-outline"></i>
                        <h2>Aucune demande</h2>
                        <p>Vous n'avez pas encore envoyé de demande d'échange.</p>
                        <button class="btn btn-gradient-primary btn-lg" onclick="window.location.href='/'">
                            <i class="mdi mdi-magnify"></i> Découvrir des objets
                        </button>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <!-- <script> </script> -->
     <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const demandeCards = document.querySelectorAll('.demande-card');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    
                    demandeCards.forEach(card => {
                        const cardStatus = card.getAttribute('data-status');
                        
                        if (filter === 'all') {
                            card.style.display = 'block';
                        } else if (filter === cardStatus) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });

    </script>
</body>
</html>
