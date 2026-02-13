<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Détails de l'objet - Takalo</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>/assets/images/favicon.ico" />
  <style>
    .item-image-gallery {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
      margin-top: 20px;
    }

    .item-image-gallery img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .item-image-gallery img:hover {
      transform: scale(1.05);
    }

    .main-image {
      width: 100%;
      max-height: 500px;
      object-fit: contain;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .item-info-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 10px;
      padding: 30px;
      margin-bottom: 20px;
    }

    .item-info-card h2 {
      margin-bottom: 15px;
      font-weight: bold;
    }

    .item-info-card .info-row {
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }

    .item-info-card .info-row i {
      margin-right: 10px;
      font-size: 20px;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/assets/images/logo.svg"
            alt="Takalo logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="<?= BASE_URL ?>/"><img
            src="<?= BASE_URL ?>/assets/images/logo-mini.svg" alt="Takalo logo mini" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block">
          <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
              </div>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Rechercher">
            </div>
          </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
              aria-expanded="false">
              <div class="nav-profile-img">
                <img src="<?= BASE_URL ?>/assets/images/faces/face1.jpg" alt="image">
                <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?= htmlspecialchars($_SESSION['username'] ?? 'Utilisateur') ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="<?= BASE_URL ?>/my-items">
                <i class="mdi mdi-package-variant me-2 text-success"></i> Mes objets
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?= BASE_URL ?>/logout">
                <i class="mdi mdi-logout me-2 text-primary"></i> Déconnexion
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="<?= BASE_URL ?>/logout">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php require_once("sidebar.php"); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-package-variant"></i>
              </span> Détails de l'objet
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Détails</li>
              </ul>
            </nav>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <a href="<?= BASE_URL ?>/" class="btn btn-gradient-light btn-sm mb-3">
                    <i class="mdi mdi-arrow-left"></i> Retour
                  </a>

                  <div class="item-info-card">
                    <h2><?= htmlspecialchars($item['name']) ?></h2>
                    <div class="info-row">
                      <i class="mdi mdi-cash"></i>
                      <span><strong>Prix:</strong> <?= number_format($item['price'], 2) ?> Ar</span>
                    </div>
                    <div class="info-row">
                      <i class="mdi mdi-account"></i>
                      <span><strong>Propriétaire:</strong>
                        <?php
                        if (isset($currentUserId) && $item['ownerId'] == $currentUserId) {
                          echo 'Moi';
                        } else {
                          echo htmlspecialchars($item['ownerUsername'] ?? 'Inconnu');
                        }
                        ?>
                      </span>
                    </div>
                    <div class="info-row">
                      <i class="mdi mdi-tag"></i>
                      <span><strong>Catégorie:</strong>
                        <?= htmlspecialchars($item['category'] ?? 'Non spécifié') ?></span>
                    </div>
                    <?php if (isset($item['created_at'])): ?>
                      <div class="info-row">
                        <i class="mdi mdi-calendar"></i>
                        <span><strong>Ajouté le:</strong> <?= date('d/m/Y', strtotime($item['created_at'])) ?></span>
                      </div>
                    <?php endif; ?>
                  </div>

                  <div class="mt-4">
                    <h4 class="mb-3"><i class="mdi mdi-text"></i> Description</h4>
                    <p class="text-muted">
                      <?= nl2br(htmlspecialchars($item['description'] ?? 'Aucune description disponible')) ?></p>
                  </div>

                  <?php if (!empty($images)): ?>
                    <div class="mt-4">
                      <h4 class="mb-3"><i class="mdi mdi-image-multiple"></i> Photos de l'objet (<?= count($images) ?>)
                      </h4>

                      <?php if (count($images) > 0): ?>
                        <div class="mb-4">
                          <img src="<?= htmlspecialchars($images[0]['imageURL']) ?>"
                            alt="<?= htmlspecialchars($item['name']) ?>" class="main-image" id="mainImage">
                        </div>
                      <?php endif; ?>

                      <div class="item-image-gallery">
                        <?php foreach ($images as $image): ?>
                          <img src="<?= htmlspecialchars($image['imageURL']) ?>"
                            alt="<?= htmlspecialchars($item['name']) ?>"
                            onclick="changeMainImage('<?= htmlspecialchars($image['imageURL']) ?>')">
                        <?php endforeach; ?>
                      </div>
                    </div>
                  <?php else: ?>
                    <div class="mt-4">
                      <div class="alert alert-info">
                        <i class="mdi mdi-information"></i> Aucune photo disponible pour cet objet.
                      </div>
                    </div>
                  <?php endif; ?>

                  <div class="mt-4">
                    <button class="btn btn-gradient-primary btn-lg" onclick="proposeExchange()">
                      <i class="mdi mdi-swap-horizontal"></i> Proposer un échange
                    </button>
                                      <button class="btn btn-gradient-light btn-lg"
                      onclick="window.location.href='/historique/<?= $item['idItem']; ?>'">
                      <i class="mdi mdi-swap-horizontal"></i> Voir historrique
                    </button>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Takalo 2026</span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">Plateforme d'échange</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?= BASE_URL ?>/assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?= BASE_URL ?>/assets/js/off-canvas.js"></script>
  <script src="<?= BASE_URL ?>/assets/js/hoverable-collapse.js"></script>
  <script src="<?= BASE_URL ?>/assets/js/misc.js"></script>
  <!-- endinject -->
  <script>
    function changeMainImage(imageUrl) {
      document.getElementById('mainImage').src = imageUrl;
    }

    function proposeExchange() {
      window.location.href = '<?= BASE_URL ?>/propositions?itemId=<?= $item['idItem'] ?>';
    }
  </script>
</body>

</html>