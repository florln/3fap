<?php
require_once 'db_connect.php';

if (isset($_GET['cart_id'])) {
    $cartId = $_GET['cart_id'];

    // Supprimer le produit du panier
    $stmt = $pdo->prepare("DELETE FROM cart WHERE product_id = ?");
    $stmt->execute([$cartId]);

    echo 'Removed';
} else {
    echo 'Erreur : aucun identifiant de produit fourni.';
}
?>
