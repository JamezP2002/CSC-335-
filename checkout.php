<?php
session_start();
include 'sql/db_config.php';

// Ensure the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

// Restrict sellers from performing checkout
if ($user_type === 'seller') {
    $_SESSION['message'] = "Sellers cannot perform checkouts.";
    header("Location: seller.php");
    exit();
}

// Fetch items from the cart
$sql = "
    SELECT 
        cart.quantity,
        ck.cd_key,
        ck.price,
        ck.key_id,
        ck.status,
        ck.seller_id,
        g.game_title,
        g.game_id
    FROM 
        cart
    INNER JOIN 
        cd_keys ck ON cart.cdkey_id = ck.key_id
    INNER JOIN 
        games g ON ck.game_id = g.game_id
    WHERE 
        cart.user_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (empty($cart_items)) {
    $_SESSION['message'] = "Your cart is empty!";
    header("Location: cart.php");
    exit();
}

foreach ($cart_items as $item) {
    // Ensure the key is still available
    if ($item['status'] !== 'available') {
        $_SESSION['message'] = "One or more items in your cart are no longer available.";
        header("Location: cart.php");
        exit();
    }

    // Record the transaction in the transactions table
    $transaction_sql = "
        INSERT INTO transactions (buyer_id, seller_id, cdkey_id, game_id, price, transaction_date)
        VALUES (?, ?, ?, ?, ?, NOW())
    ";
    $stmt = $conn->prepare($transaction_sql);
    $stmt->bind_param(
        "iiidi", 
        $user_id, 
        $item['seller_id'], 
        $item['key_id'], 
        $item['game_id'], 
        $item['price']
    );
    $stmt->execute();
    $stmt->close();

    // Mark the key as sold
    $update_cdkey_sql = "
        UPDATE cd_keys 
        SET status = 'sold' 
        WHERE key_id = ?
    ";
    $stmt = $conn->prepare($update_cdkey_sql);
    $stmt->bind_param("i", $item['key_id']);
    $stmt->execute();
    $stmt->close();
}

// Clear the user's cart
$clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($clear_cart_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

// Redirect to confirmation page with purchased keys
$_SESSION['codes'] = array_map(function($item) {
    return [
        'game_title' => $item['game_title'],
        'cd_key' => $item['cd_key']
    ];
}, $cart_items);
header("Location: confirmation.php");
exit();
?>
