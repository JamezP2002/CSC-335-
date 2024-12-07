<?php
session_start();
include 'sql/db_config.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Check if the POST request contains the `cdkey_id`
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cdkey_id'])) {
    $user_id = $_SESSION['user_id']; // Logged-in user
    $cdkey_id = intval($_POST['cdkey_id']); // Sanitize `cdkey_id`

    // Check if the item exists in the user's cart
    $check_sql = "SELECT 1 FROM cart WHERE user_id = ? AND cdkey_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $cdkey_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If item exists, delete it
        $stmt->close();
        $delete_sql = "DELETE FROM cart WHERE user_id = ? AND cdkey_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("ii", $user_id, $cdkey_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Item removed from the cart.";
        } else {
            $_SESSION['error'] = "Failed to remove item. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Item not found in your cart.";
    }
    header("Location: cart.php");
    exit();
} else {
    // Redirect back to the cart page if invalid request
    header("Location: cart.php");
    exit();
}
?>
