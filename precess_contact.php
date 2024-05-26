<?php
// Inclure le fichier de connexion à la base de données
require_once 'db_connect.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs requis sont remplis
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // Connexion à la base de données
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparer et exécuter la requête SQL d'insertion
            $stmt = $conn->prepare("INSERT INTO contact_requests (name, email, message) VALUES (:name, :email, :message)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':message', $message);
            $stmt->execute();

            // Rediriger vers la page d'accueil
            header("Location: accueil.php");
        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement de la demande de contact : " . $e->getMessage();
        }

        // Fermer la connexion
        $conn = null;
    } else {
        echo "Tous les champs requis ne sont pas remplis.";
    }
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
