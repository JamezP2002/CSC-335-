<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Array of products
$products = [
    [
        "image" => "images\heart_of_chornobyl.jpg",
        "title" => "S.T.A.L.K.E.R. 2: HEART OF CHORNOBYL",
        "price" => "39.49",
        "discount" => "-38%"
    ],
    [
        "image" => "images\minecraft.jpg",
        "title" => "Minecraft: Java & Bedrock Edition",
        "price" => "12.69",
        "discount" => "-60%"
    ],
    [
        "image" => "images\baltro.jpg",
        "title" => "Balatro PC",
        "price" => "8.89",
        "discount" => "-51%"
    ],
    [
        "image" => "images/farming.jpg",
        "title" => "Farming Simulator 25",
        "price" => "32.89",
        "discount" => "-39%"
    ],
    [
        "image" => "images\gta5.jpg",
        "title" => "Grand Theft Auto V: Premium Online Edition",
        "price" => "8.99",
        "discount" => "-86%"
    ]
];
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/catalog.css">
    <title>CD Key Store</title>
</head>
<body>
    <div class="products-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>">
                <h3><?= $product['title']; ?></h3>
                <p class="price">$<?= $product['price']; ?></p>
                <p class="discount"><?= $product['discount']; ?></p>
                <button>Buy Now</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
<?php include 'footer.php'; ?>