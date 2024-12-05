<?php
session_start();
include 'sql/db_config.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Fetch game and CD key details
$catalog_items = [];
$sql = "
    SELECT 
        games.cover_art, 
        games.game_title, 
        games.game_platform, 
        games.genre, 
        cd_keys.price 
    FROM 
        games 
    INNER JOIN 
        cd_keys 
    ON 
        games.game_id = cd_keys.game_id
";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $catalog_items[] = $row;
    }
}

// Include the header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/catalog.css">
    <title>Game Catalog</title>
</head>
<body>
    <div class="products-container">
        <?php if (!empty($catalog_items)): ?>
            <?php foreach ($catalog_items as $item): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($item['cover_art']); ?>" alt="<?= htmlspecialchars($item['game_title']); ?>">
                    <h3><?= htmlspecialchars($item['game_title']); ?></h3>
                    <p><strong>Platform:</strong> <?= htmlspecialchars($item['game_platform']); ?></p>
                    <p><strong>Genre:</strong> <?= htmlspecialchars($item['genre']); ?></p>
                    <p class="price"><strong>Price:</strong> $<?= htmlspecialchars($item['price']); ?></p>
                    <button>Buy Now</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No items available in the catalog!</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
