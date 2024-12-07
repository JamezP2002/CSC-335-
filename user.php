<?php
session_start();
include 'sql/db_config.php';

// Ensure the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

// Fetch games added by the seller
$seller_games = [];
if ($user_type === 'seller') {
    $sql = "
        SELECT 
            g.game_title, 
            g.game_platform, 
            ck.cd_key, 
            ck.price, 
            ck.status
        FROM 
            cd_keys ck
        INNER JOIN 
            games g ON ck.game_id = g.game_id
        WHERE 
            ck.seller_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $seller_games = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Fetch games bought by the buyer
$bought_games = [];
if ($user_type === 'buyer') {
    $sql = "
        SELECT 
            g.game_title, 
            g.game_platform, 
            ck.cd_key, 
            t.price, 
            t.transaction_date
        FROM 
            transactions t
        INNER JOIN 
            cd_keys ck ON t.cdkey_id = ck.key_id
        INNER JOIN 
            games g ON t.game_id = g.game_id
        WHERE 
            t.buyer_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bought_games = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user.css">
    <title>User Dashboard</title>
</head>
<body>
    <div class="main-container">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>

        <!-- Seller Section -->
        <?php if ($user_type === 'seller'): ?>
            <h2>Your Listed Games</h2>
            <?php if (!empty($seller_games)): ?>
                <table class="games-table">
                    <thead>
                        <tr>
                            <th>Game Title</th>
                            <th>Platform</th>
                            <th>CD Key</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seller_games as $game): ?>
                            <tr>
                                <td><?= htmlspecialchars($game['game_title']); ?></td>
                                <td><?= htmlspecialchars($game['game_platform']); ?></td>
                                <td><?= htmlspecialchars($game['cd_key']); ?></td>
                                <td>$<?= number_format($game['price'], 2); ?></td>
                                <td><?= htmlspecialchars($game['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have not listed any games yet. Start adding games below!</p>
            <?php endif; ?>

            <!-- Seller Actions -->
            <div class="seller-actions">
                <a href="seller.php" class="btn">Add New Game</a>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        <?php endif; ?>

        <!-- Buyer Section -->
        <?php if ($user_type === 'buyer'): ?>
            <h2>Your Purchased Games</h2>
            <?php if (!empty($bought_games)): ?>
                <table class="games-table">
                    <thead>
                        <tr>
                            <th>Game Title</th>
                            <th>Platform</th>
                            <th>CD Key</th>
                            <th>Price</th>
                            <th>Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bought_games as $game): ?>
                            <tr>
                                <td><?= htmlspecialchars($game['game_title']); ?></td>
                                <td><?= htmlspecialchars($game['game_platform']); ?></td>
                                <td><?= htmlspecialchars($game['cd_key']); ?></td>
                                <td>$<?= number_format($game['price'], 2); ?></td>
                                <td><?= htmlspecialchars($game['transaction_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have not purchased any games yet. Start exploring below!</p>
            <?php endif; ?>

            <!-- Buyer Actions -->
            <div class="buyer-actions">
                <a href="catalog.php" class="btn">Browse Games</a>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
include 'footer.php';
?>
