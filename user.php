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
    <link rel="stylesheet" href="css/user.css"> <!-- Link to the user-specific CSS -->
    <title>CDKeys User Page</title>
</head>
<body>
    <div class="main-container">
        <main>
            <h1>Welcome to Your User Page</h1>
            <p>Here you can manage your account and explore more games!</p>
            <a href="catalog.php">Go to Game Section</a>
            <br>
            <a href="logout.php">Logout</a>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
