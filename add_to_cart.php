<?php
session_start();
include 'sql/db_config.php';

// Ensure the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Ensure the user is a buyer (sellers shouldn't be able to add to cart)
if ($_SESSION['user_type'] !== 'buyer') {
    $_SESSION['message'] = "Sellers cannot add items to the cart.";
    header("Location: catalog.php");
    exit();
}

// Get the cdkey_id from the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cdkey_id'])) {
    $user_id = $_SESSION['user_id'];
    $cdkey_id = intval($_POST['cdkey_id']);

    // Check if the CD Key is still available
    $check_sql = "SELECT status FROM cd_keys WHERE key_id = ? AND status = 'available'";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $cdkey_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows === 0) {
        $_SESSION['message'] = "The selected item is no longer available.";
        header("Location: catalog.php");
        exit();
    }

    // Add the item to the cart
    $add_cart_sql = "INSERT INTO cart (user_id, cdkey_id) VALUES (?, ?)";
    $stmt = $conn->prepare($add_cart_sql);
    $stmt->bind_param("ii", $user_id, $cdkey_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Item added to your cart successfully!";
        header("Location: cart.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to add the item to your cart.";
        header("Location: catalog.php");
        exit();
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "Invalid request.";
    header("Location: catalog.php");
    exit();
}
?>
