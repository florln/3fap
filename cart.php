<?php

require_once 'db_connect.php';

// Récupérer les articles du panier
$sql_cart = "SELECT * FROM cart";
$stmt = $pdo->query($sql_cart);
$all_cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="cart.css">
    <title>In cart products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        main {
            width: 80%;
            margin: 0 auto;
        }

        .card {
            display: flex;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .images img {
            max-width: 150px;
            max-height: 150px;
            margin-right: 20px;
        }

        .caption {
            flex: 1;
        }

        .rate i {
            color: gold;
        }

        .price {
            font-weight: bold;
            color: green;
        }

        .remove {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .remove i {
            margin-right: 5px;
        }

        .total-price {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .buy-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
            margin-top: 20px;
        }

        .buy-btn:hover {
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
    </style>
</head>
<body>
    

   

    <main>
        <h1><?php echo count($all_cart); ?> Items</h1>
        <hr>
        <?php
          foreach ($all_cart as $row_cart) {
              $sql = "SELECT * FROM goodies WHERE id=" . $row_cart["product_id"];
              $stmt = $pdo->query($sql);
              $product = $stmt->fetch(PDO::FETCH_ASSOC);

              if ($product) {
                  $total_price += $product["price"];
        ?>
        <div class="card">
            <div class="images">
                <img src="<?php echo $product["image_path"]; ?>" alt="">
            </div>

            <div class="caption">
                <p class="rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </p>
                <p class="product_name"><?php echo $product["name"]; ?></p>
                <p class="price"><b>$<?php echo $product["price"]; ?></b></p>
                <p class="description"><?php echo $product["description"]; ?></p>
                <button class="remove" data-id="<?php echo $row_cart["product_id"]; ?>"><i class="fas fa-trash-alt"></i> Remove from Cart</button>
            </div>
        </div>
        <?php
              }
          }
        ?>
        <div class="total-price">
            Total: <b>$<?php echo $total_price; ?></b>
        </div>
        <a href="checkout.php" class="buy-btn">Acheter</a>
    </main>

    <script>
        var remove = document.getElementsByClassName("remove");
        for (var i = 0; i < remove.length; i++) {
            remove[i].addEventListener("click", function(event) {
                var target = event.target;
                var cart_id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        target.closest('.card').remove();
                        location.reload(); // Reload page to update total price and item count
                    }
                }

                xml.open("GET", "remove_from_cart.php?cart_id=" + cart_id, true);
                xml.send();
            })
        }
    </script>
</body>
</html>
