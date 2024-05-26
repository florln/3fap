<?php
require_once 'vendor/autoload.php'; // Inclure la bibliothèque Stripe

\Stripe\Stripe::setApiKey('sk_test_51PFPjeKp3re07QXIKXIYwTiQiAyXgXPdqduzF9ul0nqyaVxfI82USePPscNloRd1BofJtkxpEYRXDZI9uuYyPZMF00LEX4bnvM');

// Récupérer l'identifiant de la session de paiement
$sessionId = $_GET['session_id'];

try {
    // Confirmer la transaction avec Stripe
    $paymentIntent = \Stripe\PaymentIntent::retrieve($sessionId);
    $paymentIntent->confirm();

    // Rediriger l'utilisateur vers une page de confirmation de paiement réussi
    header('Location: products.php');
    exit();
} catch (Exception $e) {
    // En cas d'erreur, rediriger l'utilisateur vers une page de paiement annulé
    header('Location: products.php');
    exit();
}
?>
