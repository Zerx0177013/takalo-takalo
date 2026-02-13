<link rel="stylesheet" href="assets/css/Bootstrap.css">
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="index.html">
                    <img src="assets/images/logo.png" alt="logo" style="width:300px; height:auto; display:block;">
                </a>
            </div>
            <a href="/dashboard" class="nav-link">
                <div class="nav-profile-image">
                    <img src="/assets/images/face1.jpg" alt="profile">
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span
                        class="font-weight-bold mb-2"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Utilisateur'); ?></span>
                    <span class="text-secondary text-small">Membre</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/dashboard">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-view-dashboard menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/">
                <span class="menu-title">Accueil</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/my-items">
                <span class="menu-title">Mes Objets</span>
                <i class="mdi mdi-package-variant menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/items/new">
                <span class="menu-title">Ajouter un objet</span>
                <i class="mdi mdi-plus-circle menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/categories">
                <span class="menu-title">Catégories</span>
                <i class="mdi mdi-shape menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/mes-demandes">
                <span class="menu-title">Mes demandes</span>
                <i class="mdi mdi-file-document-box menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/other-demandes">
                <span class="menu-title">Demandes reçues</span>
                <i class="mdi mdi-file-document-box menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/logout">
                <button type="button" class="btn btn-danger">Deconnexion</button>

                <i class="mdi mdi-logout menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>