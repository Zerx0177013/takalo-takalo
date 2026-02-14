<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Takalo-Takalo - Ajouter une catégorie</title>
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
                        <h1>➕ Ajouter une catégorie</h1>
                        <p>Créez une nouvelle catégorie d'objets</p>
                    </div>
                    <a href="/categories" class="btn-add">
                        <i class="mdi mdi-arrow-left"></i>
                        Retour
                    </a>
                </div>

                <div class="categories-card">
                    <form id="categoryForm" style="padding: 20px;">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="categoryName" style="display: block; margin-bottom: 8px; font-weight: 500;">
                                Nom de la catégorie <span style="color: red;">*</span>
                            </label>
                            <input type="text" id="categoryName" name="name" class="form-control"
                                placeholder="Entrez le nom de la catégorie" required
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>

                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn-action btn-edit" style="padding: 10px 20px;">
                                <i class="mdi mdi-check"></i>
                                <span>Enregistrer</span>
                            </button>
                            <a href="/categories" class="btn-action btn-delete"
                                style="padding: 10px 20px; text-decoration: none;">
                                <i class="mdi mdi-close"></i>
                                <span>Annuler</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            require_once("footer.php");
            ?>
        </div>

    </div>

    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>

    <script>
        document.getElementById('categoryForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('categoryName').value.trim()
            };

            if (!formData.name) {
                alert('Veuillez entrer un nom de catégorie');
                return;
            }

            fetch('/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Catégorie créée avec succès !');
                        window.location.href = '/categories';
                    } else {
                        alert('Erreur: ' + (data.message || 'Échec de la création'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la création de la catégorie');
                });
        });
    </script>
</body>

</html>