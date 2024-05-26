<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Activités</title>
    <style>
        /* Styles CSS pour la mise en page */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        /* Styles CSS pour les cartes d'activité */
        .activity-card {
            background-color: #eea97a;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 10px;
            overflow: hidden;
            width: 100%; /* Largeur de chaque carte */
            display: inline-block;
            vertical-align: top;
            margin-right: 5%; /* Marge à droite pour espacement */
            position: relative;
        }
        .activity-card img {
            max-width: 50%;
            height: auto;
            border-radius: 5px;
        }
        .activity-card h3 {
            margin-top: 0;
        }
        .activity-card p {
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Limite à deux lignes */
            -webkit-box-orient: vertical;
        }
        /* Styles CSS pour la date de création */
        .created-date {
            font-style: italic;
            color: #666;
        }
        .return-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color: #007bff; /* Bleu */
            color: #fff; /* Texte blanc */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .return-button:hover {
            background-color: #0056b3; /* Bleu foncé au survol */
        }

    .btn-container {
    text-align: right;
    }

    .btn-primary {
        background-color: blue; /* Couleur de fond */
        color: white; /* Couleur du texte */
        padding: 10px 20px; /* Espacement intérieur */
        border-radius: 5px; /* Bord arrondi */
        text-decoration: none; /* Pas de soulignement */
    }

    .btn-primary:hover {
        background-color: orange; /* Couleur de fond au survol */
    }

    .action-buttons {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .action-buttons a {
        display: inline-block;
        margin-left: 5px;
        padding: 5px 10px;
        background-color: #007bff; /* Bleu */
        color: #fff; /* Texte blanc */
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .action-buttons a:hover {
        background-color: #0056b3; /* Bleu foncé au survol */
    }
    .action-buttons button {
    display: inline-block;
    height: 37px;
    margin-left: 5px;
    padding: 5px 10px;
    background-color: #dc3545; /* Rouge */
    color: #fff; /* Texte blanc */
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.action-buttons button:hover {
    background-color: #c82333; /* Rouge foncé au survol */
}


    /* Style pour la pagination */
    .pagination {
        margin-top: 20px;
    }

    .pagination ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        display: inline-block;
        margin-right: 5px;
    }

    .pagination a {
        display: inline-block;
        padding: 5px 10px;
        background-color: #eea97a; /* Bleu */
        color: #fff; /* Texte blanc */
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .pagination a:hover {
        background-color: #e76d2b; /* Bleu foncé au survol */
    }

    </style>
</head>
<body>

<div class="container">
     <!-- Bouton de retour -->
     <a href="accueil.php" class="return-button">Retour</a>


    <h2>Liste des Activités</h2>

    <?php
    // Connexion à la base de données
    require_once 'db_connect.php';

    // Pagination
    $limit = 2; // Nombre d'activités par page (2 lignes)
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Page en cours
    $start = ($page - 1) * $limit; // Offset

    // Récupération des activités pour la page en cours
    $stmt = $pdo->prepare("SELECT * FROM activites LIMIT $start, $limit");
    $stmt->execute();
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des activités
    foreach ($activities as $activity) {
        echo '<div class="activity-card">';
        echo '<h3>' . $activity['id'] . '</h3>';
        echo '<h3>' . $activity['nom'] . '</h3>';
        echo '<p>' . $activity['description'] . '</p>';
        echo '<img src="' . $activity['image_path'] . '" alt="' . $activity['nom'] . '">';
        echo '<p class="created-date">Créé le ' . $activity['created_at'] . '</p>';
        echo '<div class="action-buttons">';
        echo '<a href="view_activite.php?id=' . $activity['id'] . '">Voir</a>';
        echo '</div>';
        echo '</div>';
    }

    // Pagination
    $stmt = $pdo->prepare("SELECT COUNT(id) AS total FROM activites");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total = $result['total'];
    $pages = ceil($total / $limit); // Nombre total de pages
    echo '<div class="pagination">';
    for ($i = 1; $i <= $pages; $i++) {
        echo '<a href="?page=' . $i . '">' . $i . '</a> '; // Liens vers les autres pages
    }
    echo '</div>';
    ?>

</div>

<script>
function deleteActivite(activiteId) {
    if(confirm("Êtes-vous sûr de vouloir supprimer cette activité ?")) {
        // Créer une instance XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Définir la fonction de rappel pour gérer la réponse du serveur
        xhr.onreadystatechange = function() {
            if(xhr.readyState === XMLHttpRequest.DONE) {
                if(xhr.status === 200) {
                    // La suppression a réussi, actualiser la page
                    location.reload();
                } else {
                    // Une erreur s'est produite lors de la suppression
                    alert("Une erreur s'est produite lors de la suppression de l'activité.");
                }
            }
        };

        // Ouvrir une requête DELETE vers le script de suppression
        xhr.open("DELETE", "delete_activite.php?id=" + activiteId, true);
        
        // Envoyer la requête
        xhr.send();
    }
}
</script>

</body>
</html>

