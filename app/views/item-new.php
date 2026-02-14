<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Takalo-Takalo - Ajouter un objet</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link rel="stylesheet" href="/assets/css/itemNew.css">
</head>

<body>
    <div class="page-wrapper">
        <!-- Sidebar -->
        <?php
        require_once("sidebar.php");
        ?>

        <!-- Main Content -->
        <div class="main-panel">
            <div class="content-wrapper">
                <!-- Header -->
                <div class="header">
                    <h1>➕ Ajouter un objet</h1>
                    <p>Partagez un objet que vous souhaitez échanger avec la communauté</p>
                </div>

                <div class="form-container">
                    <form class="form-card" action="/items" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="name">
                                Nom de l'objet
                                <span class="required">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                placeholder="Ex: iPhone 12, Vélo de ville, Table basse..." required>
                        </div>

                        <div class="form-group">
                            <label for="description">
                                Description
                                <span class="required">*</span>
                            </label>
                            <textarea id="description" name="description"
                                placeholder="Décrivez votre objet en détail : état, caractéristiques, raison de l'échange..."
                                required></textarea>
                            <small class="help-text">Une description détaillée augmente vos chances d'échange</small>
                        </div>

                        <div class="form-group">
                            <label for="idcategorie">
                                Catégorie
                                <span class="required">*</span>
                            </label>
                            <select id="idcategorie" name="idcategorie" required>
                                <option value="">Sélectionnez une catégorie</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['idcategorie']); ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Électronique</option>
                                    <option value="2">Livres</option>
                                    <option value="3">Vêtements</option>
                                    <option value="4">Meubles</option>
                                    <option value="5">Sports et Loisirs</option>
                                    <option value="6">Jouets</option>
                                    <option value="7">Jardinage</option>
                                    <option value="8">Cuisine</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">
                                Valeur estimée (Ar)
                            </label>
                            <input type="number" id="price" name="price" placeholder="Ex: 450000" step="0.01" min="0">
                            <small class="help-text">Optionnel - Aide les autres utilisateurs à évaluer
                                l'échange</small>
                        </div>

                        <div class="form-group">
                            <label>
                                Photos de l'objet
                            </label>
                            <label for="imageURL" class="image-upload-zone">
                                <i class="mdi mdi-cloud-upload"></i>
                                <p><strong>Cliquez pour ajouter des photos</strong></p>
                                <small class="help-text">Formats acceptés : JPG, PNG, GIF</small>
                            </label>
                            <input type="file" id="imageURL" name="imageURL[]" accept="image/*" multiple
                                style="display: none;">
                            <div id="imagePreviewContainer" style="display: none; margin-top: 20px;"></div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-gradient-light btn-lg"
                                onclick="window.location.href='/my-items'">
                                <i class="mdi mdi-close"></i>
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-gradient-primary btn-lg">
                                <i class="mdi mdi-check"></i>
                                Publier l'objet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            require_once("footer.php");
            ?>
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

    <script>
        let selectedFiles = [];

        // Image upload preview
        document.getElementById('imageURL').addEventListener('change', function (e) {
            const files = Array.from(e.target.files);
            const previewContainer = document.getElementById('imagePreviewContainer');

            if (files.length > 0) {
                selectedFiles = files;
                displayImagePreviews();

                // Update upload zone text
                const uploadZone = document.querySelector('.image-upload-zone');
                uploadZone.querySelector('p').innerHTML = `<strong>${files.length} fichier(s) sélectionné(s)</strong>`;
            }
        });

        function displayImagePreviews() {
            const previewContainer = document.getElementById('imagePreviewContainer');
            previewContainer.innerHTML = '';

            if (selectedFiles.length === 0) {
                previewContainer.style.display = 'none';
                return;
            }

            previewContainer.style.display = 'block';
            const grid = document.createElement('div');
            grid.className = 'image-preview-grid';

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'image-preview-item';

                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="${file.name}">
                        <button type="button" class="remove-image" onclick="removeImage(${index})" title="Supprimer">
                            &times;
                        </button>
                        <div class="file-name">${file.name}</div>
                    `;

                    grid.appendChild(previewItem);
                };

                reader.readAsDataURL(file);
            });

            previewContainer.appendChild(grid);
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);

            // Update the file input
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('imageURL').files = dataTransfer.files;

            // Update display
            displayImagePreviews();

            // Update upload zone text
            const uploadZone = document.querySelector('.image-upload-zone');
            if (selectedFiles.length > 0) {
                uploadZone.querySelector('p').innerHTML = `<strong>${selectedFiles.length} fichier(s) sélectionné(s)</strong>`;
            } else {
                uploadZone.querySelector('p').innerHTML = `<strong>Cliquez pour ajouter des photos</strong>`;
            }
        }
    </script>
</body>

</html>