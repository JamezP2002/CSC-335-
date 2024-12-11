<?php
session_start();
include 'sql/db_config.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is a seller
if ($_SESSION['user_type'] === 'seller') {
    header("Location: user.php"); // Redirect sellers to the seller dashboard
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch items in the cart along with promotion details
$sql = "
    SELECT 
        cart.quantity,
        games.cover_art,
        games.game_title,
        games.game_platform,
        cd_keys.price,
        cd_keys.key_id AS cdkey_id,
        p.discount_percent,
        p.start_date,
        p.end_date,
        CASE 
            WHEN p.start_date <= CURDATE() AND p.end_date >= CURDATE() THEN 
                ROUND(cd_keys.price - (cd_keys.price * (p.discount_percent / 100)), 2)
            ELSE NULL
        END AS discounted_price
    FROM 
        cart
    INNER JOIN 
        cd_keys 
    ON 
        cart.cdkey_id = cd_keys.key_id
    INNER JOIN 
        games 
    ON 
        cd_keys.game_id = games.game_id
    LEFT JOIN 
        promotions p
    ON 
        games.game_id = p.game_id
    WHERE 
        cart.user_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css">
    <title>Your Cart</title>
</head>
<body>
    <div class="cart-container">
        <h1>Your Cart</h1>
        <?php if (!empty($cart_items)): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Platform</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th> <!-- Added Action column -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($cart_items as $item): 
                        $price = $item['discounted_price'] ?? $item['price']; // Use discounted price if available
                        $subtotal = $price * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><img src="images/<?= htmlspecialchars($item['cover_art'] ?? 'placeholder.jpg'); ?>" alt="<?= htmlspecialchars($item['game_title'] ?? 'No Title'); ?>"></td>
                            <td><?= htmlspecialchars($item['game_title'] ?? 'No Title'); ?></td>
                            <td><?= htmlspecialchars($item['game_platform'] ?? 'Unknown Platform'); ?></td>
                            <td>
                                <?php if (!empty($item['discounted_price'])): ?>
                                    <span class="original-price">$<?= number_format($item['price'], 2); ?></span>
                                    <span class="discounted-price">$<?= number_format($item['discounted_price'], 2); ?></span>
                                <?php else: ?>
                                    $<?= number_format($item['price'], 2); ?>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($item['quantity'] ?? 0); ?></td>
                            <td>$<?= number_format($subtotal, 2); ?></td>
                            <td>
                                <!-- Remove Button Form -->
                                <form method="POST" action="remove_from_cart.php">
                                    <input type="hidden" name="cdkey_id" value="<?= htmlspecialchars($item['cdkey_id']); ?>">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-summary">
                <p class="total"><strong>Total: $<?= number_format($total, 2); ?></strong></p>
                <form action="checkout.php" method="POST">
                    <button type="submit" class="checkout-btn">Proceed to Checkout</button>
                </form>
            </div>
        <?php else: ?>
            <p class="empty-cart">Your cart is empty!</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
include 'footer.php';
?>
