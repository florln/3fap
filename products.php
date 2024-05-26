<?php
// Inclure le fichier de connexion à la base de données
require_once 'db_connect.php';
require_once 'vendor/autoload.php';

// Récupérer le numéro de page actuel depuis l'URL, sinon par défaut à la page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4;
$offset = ($page - 1) * $items_per_page;

// Récupérer le nombre total de produits pour calculer le nombre de pages
$total_products = $pdo->query("SELECT COUNT(*) FROM goodies")->fetchColumn();
$total_pages = ceil($total_products / $items_per_page);

// Récupérer les produits pour la page actuelle
$stmt = $pdo->prepare("SELECT id, name, price, description, stock_quantity, image_path FROM goodies LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le contenu du panier
$sql_cart = "SELECT * FROM cart";
$stmt = $pdo->query($sql_cart);
$all_cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Liste des Produits</title>
    <style>
        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .product-item {
            border: 1px solid #ccc;
            padding: 20px;
            text-align: center;
        }
        .product-item img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .product-item a {
            display: block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .product-item a:hover {
            background-color: #0056b3;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-primary {
            background-color: blue;
            color: white;
        }
        .btn-secondary {
            background-color: orange;
            color: white;
        }
        .btn-danger {
            background-color: red;
            color: white;
        }
        .btn:hover {
            background-color: darkblue;
        }
        .cart-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: blue;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5em;
            cursor: pointer;
        }
        .cart-floating span {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75em;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #007bff;
            text-decoration: none;
            padding: 10px 15px;
            border: 1px solid #ddd;
            margin: 0 5px;
        }
        .pagination a:hover {
            background-color: #f1f1f1;
        }
        .pagination .active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="cart-floating" onclick="window.location.href='cart.php'">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-count"><?php echo count($all_cart); ?></span>
    </div>
    <h1 style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif"><i>Nos Produits</i></h1>
    <br>


    <div class="products-container">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>Prix: <?php echo htmlspecialchars($product['price']); ?> €</p>
                <p>Stock: <?php echo htmlspecialchars($product['stock_quantity']); ?></p>
                <a href="payer.html" class="btn btn-primary buy-btn">Acheter</a> <br>
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <button type="submit" class="btn btn-secondary">Ajouter au panier</button>
                    <div id="alert-<?php echo htmlspecialchars($product['id']); ?>"></div>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>

    <script>
        var productButtons = document.getElementsByClassName("add");
        for (var i = 0; i < productButtons.length; i++) {
            productButtons[i].addEventListener("click", function (event) {
                var target = event.target;
                var id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        target.innerHTML = "Ajouté au panier";
                        document.getElementById("badge").innerHTML = data.num_cart + 1;
                    }
                };

                xml.open("GET", "../db_connect.php?id=" + id, true);
                xml.send();
            });
        }
    </script>
</body>
</html>
