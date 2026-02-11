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
            margin-left: 50px;
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

        /* Form Container */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }

        .form-group {
            margin-bottom: 28px;
        }

        .form-group label {
            display: block;
            color: #2d3436;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-group label .required {
            color: #e74c3c;
            margin-left: 4px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
            background: #fafafa;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="number"]:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group .help-text {
            color: #636e72;
            font-size: 0.85rem;
            margin-top: 6px;
            display: block;
        }

        .image-upload-zone {
            border: 2px dashed #d0d0d0;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .image-upload-zone:hover {
            border-color: #667eea;
            background: #f5f7ff;
        }

        .image-upload-zone i {
            font-size: 60px;
            color: #b2bec3;
            margin-bottom: 15px;
            display: block;
        }

        .image-upload-zone p {
            color: #636e72;
            margin-bottom: 8px;
        }

        .image-upload-zone input[type="file"] {
            display: none;
        }

        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .image-preview-item {
            position: relative;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            background: #fafafa;
            aspect-ratio: 1;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-item .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(231, 76, 60, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            line-height: 1;
            transition: all 0.3s ease;
        }

        .image-preview-item .remove-image:hover {
            background: #c0392b;
            transform: scale(1.1);
        }

        .image-preview-item .file-name {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px;
            font-size: 0.75rem;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }

        .form-actions button {
            flex: 1;
            padding: 16px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-cancel {
            background: #f0f0f0;
            color: #2d3436;
        }

        .btn-cancel:hover {
            background: #e0e0e0;
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

            .form-card {
                padding: 30px;
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

            .form-card {
                padding: 25px 20px;
            }

            .form-actions {
                flex-direction: column;
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
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Ex: iPhone 12, Vélo de ville, Table basse..."
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">
                            Description
                            <span class="required">*</span>
                        </label>
                        <textarea
                            id="description"
                            name="description"
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
                        <input
                            type="number"
                            id="price"
                            name="price"
                            placeholder="Ex: 450000"
                            step="0.01"
                            min="0">
                        <small class="help-text">Optionnel - Aide les autres utilisateurs à évaluer l'échange</small>
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
                        <input type="file" id="imageURL" name="imageURL[]" accept="image/*" multiple style="display: none;">
                        <div id="imagePreviewContainer" style="display: none; margin-top: 20px;"></div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="window.location.href='/items/new'">
                            <i class="mdi mdi-close"></i>
                            Annuler
                        </button>
                        <button type="submit" class="btn-submit">
                            <i class="mdi mdi-check"></i>
                            Publier l'objet
                        </button>
                    </div>
                </form>
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

    <script>
        let selectedFiles = [];

        // Image upload preview
        document.getElementById('imageURL').addEventListener('change', function(e) {
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

                reader.onload = function(e) {
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