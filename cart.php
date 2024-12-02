<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include the header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css"> <!-- Link to the index-specific CSS -->
    <title>CDKeys shopping cart</title>
</head>
<body>
    <div class="main-container">
        <main>
            <h1>Shopping cart</h1>
            <p>WIP</p>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
