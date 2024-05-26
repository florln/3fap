<?php
// Inclure le fichier de connexion à la base de données
require_once 'db_connect.php';

// Récupérer les produits de la base de données
$stmt = $pdo->query("SELECT * FROM goodies");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style_accueil.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Mon Application</title>
</head>
<body>

<!-- En-tête -->
<header>
    <!-- Logo et liens de navigation -->
    <div class="left-section">
        <img src="assets/images/logo.png" alt="Logo">
        <nav>
            <?php
            // Inclure le fichier de connexion à la base de données
            require_once 'db_connect.php';

          

            if (isset($_SESSION['user_id'])) {
                // Récupérer le nom d'utilisateur de l'utilisateur connecté
                $user_id = $_SESSION['user_id'];
                $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
                if ($user) {
                    $username = $user['username'];
                    // Afficher les liens des pages
                    echo '<a href="accueil.php">Accueil</a>';
                    echo '<a href="liste_activites.php">Activités</a>';
                    echo '<a href="products.php">Produits</a>';
                    echo '<a href="posts/view_posts.php">Blog</a>';
                }
            } else {
                // Afficher les liens de connexion et d'inscription
                echo '<a href="accueil.php">Accueil</a>';
                echo '<a href="liste_activites.php">Activités</a>';
                echo '<a href="products.php">Produits</a>';
                echo '<a href="posts/view_posts.php">Blog</a>';
            }
            ?>
        </nav>
    </div>

    <!-- Section pour l'icône utilisateur et le menu déroulant -->
    <div class="right-section">
        <?php
        if (isset($_SESSION['user_id'])) {
            if ($user) {
                // Afficher l'icône utilisateur avec le menu déroulant
                echo '<div class="user-dropdown">';
                echo '<img src="assets/images/icon_user.png" alt="User Icon" onclick="toggleDropdown()">';
                echo '<span class="user-name">' . $username . '</span>';
                echo '<div class="user-dropdown-content" id="dropdownContent">';
                echo '<a href="authentication/profil.php">Profil</a>';
                echo '<a href="authentication/logout.php">Déconnexion</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            // Afficher le lien de connexion
            echo '<a href="authentication/login.php">Connexion</a>';
            // Afficher le lien d'inscription
            echo '<a href="authentication/register.php">Inscription</a>';
        }
        ?>
    </div>
</header>


<style>

    /* Style pour le header */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #007bff; /* Couleur bleue */
    padding: 10px 20px;
    color: white; /* Texte blanc */
}

/* Style pour la section gauche du header */
.left-section {
    display: flex;
    align-items: center;
}

.left-section img {
    width: 40px;
    margin-right: 10px;
}

.left-section nav a {
    color: white; /* Texte blanc */
    text-decoration: none;
    margin-right: 20px;
    transition: color 0.3s ease;
}

.left-section nav a:hover {
    color: orange; /* Couleur orange au survol */
}

/* Style pour les liens de connexion et d'inscription */
.right-section a {
    color: #fff; /* Couleur blanche */
    text-decoration: none;
    margin-left: 20px; /* Marge à gauche pour séparer les liens */
}

.right-section a:hover {
    color: blue; /* Couleur blanche légèrement plus foncée au survol */
}


/* Style pour le menu déroulant */
.user-dropdown {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.user-dropdown-content {
    display: none;
    position: absolute;
    background-color: #fff; /* Fond blanc */
    min-width: 120px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Ombre légère */
    z-index: 1;
}

.user-dropdown-content a {
    color: #000; /* Texte noir */
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.user-dropdown-content a:hover {
    background-color: #f9f9f9; /* Fond gris clair au survol */
}

/* Affichage du menu déroulant lorsqu'il est ouvert */
.show {
    display: block;
}

/* Style pour l'icône utilisateur */
.user-dropdown img {
    width: 30px;
    height: 30px;
    border-radius: 50%; /* Forme arrondie */
    margin-right: 10px;
    vertical-align: middle;
}

/* Style pour le nom d'utilisateur */
.user-name {
    font-weight: bold;
}


    /* Styles pour la bannière et les diapositives */
.banner {
    width: 100%; /* Prendre toute la largeur de l'écran */
    height: 70vh; /* Prendre toute la hauteur de l'écran */
    overflow: hidden;
    position: relative;
    margin: auto; /* Pour centrer la bannière horizontalement */
}

.banner-slider {
    display: flex;
    transition: transform 0.5s ease-in-out;
    height: 100%; /* Prendre toute la hauteur de la bannière */
}

.slide {
    width: 100%;
    flex: 0 0 auto;
    text-align: center;
    position: relative; /* Positionnement relatif pour positionner le texte */
}

.slide img {
    width: 100%; /* Prendre toute la largeur de la diapositive */
    height: 100%; /* Remplir toute la hauteur de la diapositive */
    object-fit: cover; /* Ajuster l'image pour couvrir toute la diapositive */
}

.text {
    position: absolute;
    top: 50%; /* Centrer verticalement */
    left: 50%;
    transform: translate(-50%, -50%); /* Centrer horizontalement et verticalement */
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
}

/* Styles pour le carousel de produits */
.carousel-inner {
            display: flex;
        }
        .carousel-item {
            flex: 0 0 25%; /* 4 items per slide */
            max-width: 25%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .product-item {
            text-align: center;
            padding: 15px;
        }
        .product-item img {
            max-width: 100%;
            height: auto;
        }

</style>

<!-- Contenu de la page -->
<main style="background-color: beige;">
    <!-- Bannière Défilante -->
    <div class="banner">
        <div class="banner-slider">
            <div class="slide">
                <img src="assets/images/3.jpg" alt="Image 1">
                <div class="text"><h1><i>Decouvrez les splendeurs de l'Univers</i></h1></div>
            </div>
            <div class="slide">
                <img src="assets/images/2.jpeg" alt="Image 2">
                <div class="text"><h1><i>Des correspondants au cœur des régions pour rapprocher la PoleIt de ses membres</i></h1></div>
            </div>
            <div class="slide">
                <img src="assets/images/1.png" alt="Image 2">
                <div class="text"><h1><i>Maillage territorial et lien de proximité</i></h1></div>
            </div>
        </div>
    </div>
</main>

<br>

   
        <div class="section-1" style="background-color: beige;">
            <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">PoleIT est un centre ouverte à tous, nouvellement etabli en Orléans.
            Son but est de diffuser les sciences de l’Univers et faire participer les amateurs à leurs progrès.</h2>
            <div class="site-button">
                <div class="centered-button">
                    <a href="about.php" class="btn btn-primary">En savoir plus</a>
                </div>
            </div>
        </div>
        <br>

 
   <h1 style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif"><i>Fil d'actualités</i></h1><br>

    <div class="news-feed">
        <div class="news-item">
            <img src="assets/images/1.webp" alt="Image 1">
            <div class="news-content">
                <h3>Titre de l'actualité 1</h3>
                <p>Description de l'actualité 1</p>
                <a href="#" class="read-more">Lire la suite</a>
            </div>
        </div>
        <div class="news-item">
            <img src="assets/images/1.webp" alt="Image 2">
            <div class="news-content">
                <h3>Titre de l'actualité 2</h3>
                <p>Description de l'actualité 2</p>
                <a href="#" class="read-more">Lire la suite</a>
            </div>
        </div>
        <div class="news-item">
            <img src="assets/images/1.webp" alt="Image 2">
            <div class="news-content">
                <h3>Titre de l'actualité 2</h3>
                <p>Description de l'actualité 2</p>
                <a href="#" class="read-more">Lire la suite</a>
            </div>
        </div>
        <!-- <div class="news-item">
            <img src="assets/images/1.webp" alt="Image 1">
            <div class="news-content">
                <h3>Titre de l'actualité 1</h3>
                <p>Description de l'actualité 1</p>
                <a href="#" class="read-more">Lire la suite</a>
            </div>
        </div>
        <div class="news-item">
            <img src="assets/images/1.webp" alt="Image 2">
            <div class="news-content">
                <h3>Titre de l'actualité 2</h3>
                <p>Description de l'actualité 2</p>
                <a href="#" class="read-more">Lire la suite</a>
            </div>
        </div>
        <div class="news-item">
            <img src="assets/images/1.webp" alt="Image 2">
            <div class="news-content">
                <h3>Titre de l'actualité 2</h3>
                <p>Description de l'actualité 2</p>
                <a href="#" class="read-more">Lire la suite</a>
            </div>
        </div> -->
    </div>
    <br>

    <h1 style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif"><i>Evénements à venir</i></h1><br>

    <section class="upcoming-events">
    <div class="events-list">
        <a href="event1.html" class="event-link">
            <div class="event-item">
                <div class="event-thumbnail">
                    <img src="assets/images/3.jpg" alt="Événement 1">
                </div>
                <div class="event-details">
                    <h3>Événement 1</h3>
                    <p>Description de l'événement 1Description de l'événement 1Description de l'événement 1</p>
                </div>
            </div>
        </a>
        <a href="event1.html" class="event-link">
            <div class="event-item">
                <div class="event-thumbnail">
                    <img src="assets/images/3.jpg" alt="Événement 1">
                </div>
                <div class="event-details">
                    <h3>Événement 1</h3>
                    <p>Description de l'événement 1</p>
                </div>
            </div>
        </a>
        <a href="event1.html" class="event-link">
            <div class="event-item">
                <div class="event-thumbnail">
                    <img src="assets/images/3.jpg" alt="Événement 1">
                </div>
                <div class="event-details">
                    <h3>Événement 1</h3>
                    <p>Description de l'événement 1</p>
                </div>
            </div>
        </a>
        <!-- Ajouter d'autres événements selon vos besoins -->
    </div>
    <div class="main-event">
        <a href="main-event.html" class="event-link">
            <div class="event-thumbnail">
                <img src="assets/images/3.jpg" alt="Événement Principal">
            </div>
            <div class="event-details_1">
                <h2>Événement Principal</h2>
                <p class="main-event">Description de l'événement principalDescription de l'événement principal</p>
            </div>
        </a>
    </div>
</section>
<br>
<h1 style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif"><i>Memories</i></h1><br>
<section class="gallery">

    <div class="gallery">
        <div class="image"><img src="assets/images/4.webp" alt="Image 1"></div>
        <div class="image"><img src="assets/images/4.webp" alt="Image 2"></div>
        <div class="image"><img src="assets/images/4.webp" alt="Image 3"></div>
        <div class="image"><img src="assets/images/4.webp" alt="Image 3"></div>
        <!-- Ajoutez autant d'images que nécessaire -->
    </div>
</section>

<br>
    <!-- Section de Produits Défilants -->
    <?php
    require_once 'products.php';
    ?>
<br>
<div class="gallery-text">
    <h3>Le réseau des Correspondants de la PoleIt a pour vocation d’assurer un contact de proximité avec les membres de province, d’y promouvoir les activités de la SAF et de recueillir et diffuser des informations sur les manifestations et les événements qui y sont organisés.</h3>
</div>
<section class="split-section">
    <div class="image-section">
        <img src="assets/images/LOGO-LASTRONOMIE.png" alt="Description de l'image">
    </div>
    <div class="text-section">
       <a href=""> <p>
            L’Astronomie a été créée en 1882 par Camille Flammarion et a pour objectif de promouvoir le développement et la pratique de l’astronomie. Le magazine l’Astronomie est édité par la Société astronomique de France. Il est disponible en versions papier et numérique et diffusé en kiosques.
            Tous les mois, dans le magazine l’Astronomie, retrouvez l’actualité astronomique expliquée par des spécialistes, des articles de fond rédigés par des chercheurs experts dans leur domaine, l’histoire de l’astronomie, des conseils pour observer le ciel, les événements astronomiques…</p>
        </a>
    </div>
</section>
<section class="activities-section">
    <div class="container">
        <h1 style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif"><i>Nos activités</i></h1><br>
        <div class="activities-list">
            <!-- Les activités seront affichées ici -->
            <?php
            // Inclure le fichier de connexion à la base de données
            require_once 'db_connect.php';

            // Récupérer les données des activités depuis la base de données
            $stmt = $pdo->query("SELECT * FROM activites");
            $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Parcourir les activités et les afficher
            foreach ($activities as $activity) {
                echo '<div class="activity">';
                echo '<div class="activity-image">';
                echo '<img src="' . $activity['image_path'] . '" alt="Image de l\'activité">';
                echo '</div>';
                echo '<h3>' . $activity['nom'] . '</h3>';
                echo '<p>' . $activity['description'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>
<section class="contact-section">
    <div class="container-contact">
        <div class="contact-content">
            <div class="contact-form">
                <h2>Contactez-nous</h2>
                <form action="process_contact.php" method="post">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
            <div class="contact-image">
                <img src="assets/images/R.jpeg" alt="Contact Image">
            </div>
        </div>
    </div>
</section>




</div>

<br>

<footer class="footer-20192">
      <div class="site-section">
        <div class="container">

          <div class="cta d-block d-md-flex align-items-center px-5">
            <div>
              <h2 class="mb-0">Ready for a next project?</h2>
              <h3 class="text-dark">Let's get started!</h3>
            </div>
            <div class="ml-auto">
              <a href="" class="btn btn-dark rounded-0 py-3 px-5">Contact us</a>
            </div>
          </div>
          <div class="row">

            <div class="col-sm">
              <a href="#" class="footer-logo">PoleIT</a>
              <p class="copyright">
                <small>&copy; 2023</small>
              </p>
            </div>
            <div class="col-sm">
              <h3>Customers</h3>
              <ul class="list-unstyled links">
                <li><a href="#">Buyer</a></li>
                <li><a href="#">Supplier</a></li>
              </ul>
            </div>
            <div class="col-sm">
              <h3>Company</h3>
              <ul class="list-unstyled links">
                <li><a href="#">About us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Contact us</a></li>
              </ul>
            </div>
            <div class="col-sm">
              <h3>Further Information</h3>
              <ul class="list-unstyled links">
                <li><a href="#">Terms &amp; Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
              </ul>
            </div>
            <div class="col-md-3">
              <h3>Follow us</h3>
              <ul class="list-unstyled social">
                <li><a href="#"><span class="icon-facebook"></span></a></li>
                <li><a href="#"><span class="icon-twitter"></span></a></li>
                <li><a href="#"><span class="icon-linkedin"></span></a></li>
                <li><a href="#"><span class="icon-medium"></span></a></li>
                <li><a href="#"><span class="icon-paper-plane"></span></a></li>
              </ul>
            </div>
            
          </div>
        </div>
      </div>
    </footer>



<script>
    function toggleDropdown() {
        var dropdownContent = document.getElementById("dropdownContent");
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    }
</script>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleDropdown() {
        var dropdownContent = document.getElementById('dropdownContent');
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    }
</script>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
