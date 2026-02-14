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
    <link rel="stylesheet" href="/assets/css/demande.css">
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

                <div class="demandes-container">
                    <?php if (!empty($historique)) { ?>
                        <?php foreach ($historique as $echange) { ?>
                            <div class="demande-card" data-status="<?php
                            $statusId = $echange['idDemandeStatus'] ?? 1;
                            if ($statusId == 2) {
                                echo 'accepted';
                            } elseif ($statusId == 3) {
                                echo 'refused';
                            } else {
                                echo 'pending';
                            }
                            ?>">
                                <div class="demande-header">
                                </div>
                                <div class="demande-body">
                                    <div class="demande-info">
                                        <label><i class="mdi mdi-account"></i> Ancien proprietaire</label>
                                        <span><?php echo htmlspecialchars($echange['ancien_proprietaire']); ?></span>
                                    </div>
                                    <div class="demande-info">
                                        <label><i class="mdi mdi-account-check"></i> Nouveau proprietaire</label>
                                        <span><?php echo htmlspecialchars($echange['nouveau_proprietaire']); ?></span>
                                    </div>
                                    <div class="demande-info">
                                        <label><i class="mdi mdi-package-variant"></i> Date</label>
                                        <span><?php echo htmlspecialchars($echange['dateEchange']); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="empty-state">
                            <i class="mdi mdi-email-outline"></i>
                            <h2>Aucune histoire</h2>
                            <p>Cet objet n'a jamais été échangé.</p>
                            <button class="btn btn-gradient-primary btn-lg" onclick="window.location.href='/'">
                                <i class="mdi mdi-magnify"></i> Découvrir des objets
                            </button>
                        </div>
                    <?php } ?>
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