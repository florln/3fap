<?php
require_once 'db_connect.php';
require_once 'vendor/autoload.php';

session_start();



// Gérer l'ajout, la modification et la suppression des goodies
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock_quantity = $_POST['stock_quantity'];
            $image_path = 'uploads/' . basename($_FILES['image']['name']);
            
            // Déplacer le fichier téléchargé vers le dossier 'uploads'
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

            $stmt = $pdo->prepare("INSERT INTO goodies (name, description, price, stock_quantity, image_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $stock_quantity, $image_path]);

        } elseif ($_POST['action'] === 'edit') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock_quantity = $_POST['stock_quantity'];
            $image_path = $_POST['current_image'];

            if (!empty($_FILES['image']['name'])) {
                $image_path = 'uploads/' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
            }

            $stmt = $pdo->prepare("UPDATE goodies SET name = ?, description = ?, price = ?, stock_quantity = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $stock_quantity, $image_path, $id]);

        } elseif ($_POST['action'] === 'delete') {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM goodies WHERE id = ?");
            $stmt->execute([$id]);
        }
    }
}

// Récupérer les produits depuis la base de données
$stmt = $pdo->query("SELECT id, name, price, description, stock_quantity, image_path FROM goodies");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group input[type="file"] {
            padding: 0;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .product-list {
            max-width: 800px;
            margin: 20px auto;
            border-collapse: collapse;
            width: 100%;
        }
        .product-list th, .product-list td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        .product-list th {
            background-color: #f4f4f4;
        }
        .product-actions button {
            margin-right: 10px;
            padding: 5px 10px;
        }
        .product-actions form {
            display: inline;
        }
    </style>
</head>
<body>
    <h1>Gestion des Produits</h1>
    <div class="form-container">
        <h2>Ajouter un Nouveau Produit</h2>
        <form action="manage_goodies.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Prix</label>
                <input type="number" name="price" id="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Quantité en Stock</label>
                <input type="number" name="stock_quantity" id="stock_quantity" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <button type="submit">Ajouter le Produit</button>
            </div>
        </form>
    </div>

    <h2>Liste des Produits</h2>
    <table class="product-list">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?> €</td>
                    <td><?php echo htmlspecialchars($product['stock_quantity']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: auto;"></td>
                    <td class="product-actions">
                        <form action="manage_goodies.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                        <button class="btn btn-secondary" onclick="populateEditForm('<?php echo htmlspecialchars(json_encode($product)); ?>')">Modifier</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-container" id="editFormContainer" style="display: none;">
        <h2>Modifier le Produit</h2>
        <form action="manage_goodies.php" method="post" enctype="multipart/form-data" id="editForm">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="editId">
            <div class="form-group">
                <label for="editName">Nom</label>
                <input type="text" name="name" id="editName" required>
            </div>
            <div class="form-group">
                <label for="editDescription">Description</label>
                <textarea name="description" id="editDescription" required></textarea>
            </div>
            <div class="form-group">
                <label for="editPrice">Prix</label>
                <input type="number" name="price" id="editPrice" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="editStockQuantity">Quantité en Stock</label>
                <input type="number" name="stock_quantity" id="editStockQuantity" required>
            </div>
            <div class="form-group">
                <label for="editImage">Image</label>
                <input type="file" name="image" id="editImage" accept="image/*">
                <input type="hidden" name="current_image" id="editCurrentImage">
            </div>
            <div class="form-group">
                <button type="submit">Modifier le Produit</button>
            </div>
        </form>
    </div>

    <script>
        function populateEditForm(product) {
            var productObj = JSON.parse(product);
            document.getElementById('editId').value = productObj.id;
            document.getElementById('editName').value = productObj.name;
            document.getElementById('editDescription').value = productObj.description;
            document.getElementById('editPrice').value = productObj.price;
            document.getElementById('editStockQuantity').value = productObj.stock_quantity;
            document.getElementById('editCurrentImage').value = productObj.image_path;
            document.getElementById('editFormContainer').style.display = 'block';
        }
    </script>
</body>
</html>
