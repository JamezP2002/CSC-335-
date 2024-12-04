<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database configuration
include 'sql/db_config.php';

// Fetch products from the database
$sql = "SELECT * FROM games";
$result = $conn->query($sql);

// Check if products exist
$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

include 'header.php'; // Include the header
?>

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
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['cover_art']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    <h3><?= htmlspecialchars($product['name']); ?></h3>
                    <p class="price">$<?= htmlspecialchars($product['price']); ?></p>
                    <p class="quantity">Quantity: <?= htmlspecialchars($product['quantity']); ?></p>
                    <button>Buy Now</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available yet!</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include 'footer.php'; // Include the footer ?>
