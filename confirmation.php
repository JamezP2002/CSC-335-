<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$codes = $_SESSION['codes'] ?? null;
unset($_SESSION['codes']);

if (!$codes) {
    $_SESSION['message'] = "No game codes found!";
    header("Location: catalog.php");
    exit();
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/confirmation.css">
    <title>Order Confirmation</title>
</head>
<body>
    <div class="confirmation-container">
        <h1>Thank You for Your Purchase!</h1>
        <p>Here are your game codes:</p>
        <div class="codes-list">
            <?php foreach ($codes as $code): ?>
                <div class="code-card">
                    <h3><?= htmlspecialchars($code['game_title']); ?></h3>
                    <p><strong>Code:</strong> <?= htmlspecialchars($code['cd_key']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="catalog.php" class="btn">Browse More Games</a>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
