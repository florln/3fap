<?php
// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure le fichier de connexion à la base de données
    require_once 'db_connect.php';

    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = $_POST['description'];

    // Vérifier si un fichier a été téléchargé
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Récupérer le chemin temporaire du fichier téléchargé
        $image_tmp = $_FILES['image']['tmp_name'];

        // Récupérer le nom du fichier téléchargé
        $image_name = $_FILES['image']['name'];

        // Déplacer le fichier téléchargé vers le dossier de destination
        move_uploaded_file($image_tmp, 'uploads/' . $image_name);

        // Chemin relatif de l'image pour enregistrer dans la base de données
        $image_path = 'uploads/' . $image_name;

        // Requête SQL pour insérer le produit dans la base de données
        $sql = "INSERT INTO goodies (name, price, stock_quantity, description, image_path) VALUES (?, ?, ?, ?, ?)";

        // Préparer la requête
        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $price, PDO::PARAM_STR);
        $stmt->bindParam(3, $stock_quantity, PDO::PARAM_INT);
        $stmt->bindParam(4, $description, PDO::PARAM_STR);
        $stmt->bindParam(5, $image_path, PDO::PARAM_STR);

        // Exécution de la requête
        if ($stmt->execute()) {
            // Redirection vers la page d'accueil ou une autre page après l'insertion réussie
            header("Location: products.php");
            exit();
        } else {
            // En cas d'erreur lors de l'exécution de la requête
            echo "Erreur lors de l'ajout du produit.";
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Nouveau Produit</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style pour le formulaire de création de produit */
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Créer un Nouveau Produit</h2>
    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom du Produit:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="price">Prix:</label>
            <input type="number" id="price" name="price" step="0.01" min="0" required>
        </div>
        <div class="form-group">
            <label for="stock_quantity">Quantité en Stock:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" min="0" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image du Produit:</label>
            <input type="file" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

</body>
</html>
