<?php

// Informations de connexion à la base de données
$host = 'localhost';
$dbname = 'bd_3fap';
$username = 'root';
$password = '';




// Tentative de connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Définir le jeu de caractères en UTF-8
    $pdo->exec("set names utf8");
} catch (PDOException $e) {
    // En cas d'échec de connexion, afficher l'erreur
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die(); // Arrêter l'exécution du script
}

// Fonction pour hasher les mots de passe
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fonction pour vérifier les mots de passe hashés
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Fonction pour créer un nouveau compte utilisateur
function createUser($username, $password, $firstName, $lastName, $email, $phoneNumber, $dateOfBirth) {
    global $pdo;
    $hashedPassword = hashPassword($password);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role, first_name, last_name, email, phone_number, date_of_birth) VALUES (?, ?, 'User', ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $firstName, $lastName, $email, $phoneNumber, $dateOfBirth]);
}

// Fonction pour vérifier l'existence d'un utilisateur
function userExists($username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetchColumn() > 0;
}

// Fonction pour authentifier un utilisateur
function authenticateUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && verifyPassword($password, $user['password'])) {
        return $user;
    }
    return null;
}
?>
