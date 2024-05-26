<?php
require_once 'vendor/autoload.php'; // Inclure la bibliothèque Stripe

\Stripe\Stripe::setApiKey('sk_test_51PFPjeKp3re07QXIKXIYwTiQiAyXgXPdqduzF9ul0nqyaVxfI82USePPscNloRd1BofJtkxpEYRXDZI9uuYyPZMF00LEX4bnvM');

// Récupérer l'identifiant du produit depuis le formulaire
$productId = $_POST['productId'];

try {
    // Créer une session de paiement avec Stripe
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => 5000, // Montant en centimes (par exemple, 50€)
                    'product' => $productId, // ID du produit à acheter
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => 'http://votre-site.com/paiement_reussi.php',
        'cancel_url' => 'http://votre-site.com/paiement_annule.php',
    ]);

    // Retourner la session de paiement au format JSON
    header('Content-Type: application/json');
    echo json_encode(['id' => $session->id]);
} catch (Exception $e) {
    // En cas d'erreur, retourner une réponse d'erreur
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
