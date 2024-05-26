<?php
// Inclure le fichier de connexion à la base de données
require_once 'db_connect.php';

// Vérifier si l'identifiant du produit est présent dans les données POST
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Vérifier si le produit existe déjà dans le panier
    $sql_check = "SELECT COUNT(*) FROM cart WHERE product_id = :product_id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute(['product_id' => $product_id]);
    $count = $stmt_check->fetchColumn();

    // Si le produit existe déjà dans le panier, afficher un message d'alerte
    if ($count > 0) {
        echo "<script>alert('Ce produit est déjà dans votre panier.');</script>";
        echo "<script>window.location = 'products.php';</script>";
        exit();
    }

    // Insérer l'identifiant du produit dans la table cart
    $sql_insert = "INSERT INTO cart (product_id) VALUES (:product_id)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute(['product_id' => $product_id]);

    // Rediriger l'utilisateur vers la page des produits ou afficher un message de succès
    header("Location: products.php");
    exit();
}
?>