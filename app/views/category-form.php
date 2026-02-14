<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Takalo-Takalo - Modifier la catégorie</title>
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
                        <h1>✏️ Modifier la catégorie</h1>
                        <p>Modifiez les informations de la catégorie</p>
                    </div>
                    <a href="/categories" class="btn-add">
                        <i class="mdi mdi-arrow-left"></i>
                        Retour à la liste
                    </a>
                </div>

                <div class="categories-card">
                    <form id="editCategoryForm" class="category-form">
                        <div class="form-group">
                            <label for="categoryName">Nom de la catégorie</label>
                            <input type="text" id="categoryName" name="name" class="form-control"
                                value="<?= htmlspecialchars((string) ($category['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit">
                                <i class="mdi mdi-content-save"></i>
                                Enregistrer les modifications
                            </button>
                            <a href="/categories" class="btn-cancel">
                                Annuler
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
        document.getElementById('editCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('categoryName').value
            };

            fetch('/categories/<?= (int) ($category['idcategorie'] ?? 0) ?>', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Catégorie modifiée avec succès !');
                        window.location.href = '/categories';
                    } else {
                        alert('Erreur lors de la modification: ' + (data.message || 'Erreur inconnue'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la modification de la catégorie');
                });
        });
    </script>

    <style>
        body {
            background: #f4f6fb;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
        }

        .main-content {
            padding: 40px 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-text h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2b2b2b;
            margin: 0;
        }

        .header-text p {
            margin: 5px 0 0;
            color: #6c757d;
            font-size: 14px;
        }

        .btn-add {
            background: white;
            border: 1px solid #e3e6f0;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all .2s;
        }

        .btn-add:hover {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .categories-card {
            background: white;
            border-radius: 14px;
            padding: 35px;
            max-width: 650px;
            margin: auto;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
            border: 1px solid #eef0f6;
        }

        .category-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #2b2b2b;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #dcdfea;
            font-size: 14px;
            background: #f9fafc;
            transition: all .2s;
        }

        .form-control:focus {
            background: white;
            border-color: #5e72e4;
            box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.15);
            outline: none;
        }

        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 12px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #5e72e4, #324cdd);
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: .25s;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(50, 76, 221, .35);
        }

        .btn-cancel {
            background: #eef0f6;
            color: #333;
            padding: 12px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: .2s;
        }

        .btn-cancel:hover {
            background: #dcdfea;
        }
    </style>

</body>

</html>