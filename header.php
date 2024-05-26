<?php
  
require_once 'db_connect.php';

$sql_cart = "SELECT * FROM cart";
$stmt = $pdo->query($sql_cart);
$all_cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">

    <style>
      *{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    text-decoration: none;
    color: black;
}

html{
    font-size: 62.5%;
}

header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 50px;
    padding: 0 20px;
    box-shadow: 1px 1px 1px 1px lightgrey;
}

header a{
    position: relative;
    font-size: 2rem;
}

header a:hover{
    color: red;
}

header #main_tabs a{
    margin-left: 1em;
}

header a span{
    position: absolute;
    width: 20px;
    height: 20px;
    top: -30%;
    right: -30%;
    background-color: black;
    color: white;
    border-radius: 50%;
    font-size: 1.5rem;
    padding: .2em;
    text-align: center;
}
    </style>
</head>
<body>
     <header>
         <h1><a href="home.php"><img style="width: 50px; height: 40px;" src="logo.jpg" alt=""></a></h1>
         <div id="main_tabs">
             <a href="upload.php">Upload</a>
             <a href="Home.php">Products</a>
         </div>
         <a href="cart.php">Cart <span id="badge"><?php echo count($all_cart); ?></span></a>
     </header>
</body>
</html>