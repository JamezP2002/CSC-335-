<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Dummy credentials for login
    $valid_username = "user";
    $valid_password = "password";

    // Check if the credentials are correct
    if ($username === $valid_username && $password === $valid_password) {
        // Set the session variable to indicate the user is logged in
        $_SESSION['loggedin'] = true;

        // Redirect to the user page
        header("Location: user.php");
        exit();
    } else {
        $error_message = "Invalid username or password!";
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
    <link rel="stylesheet" href="css/login.css"> <!-- Link to the login-specific CSS -->
    <title>Login</title>
</head>
<body>
    <div class="main-container">
        <main>
            <h1>Login</h1>
            <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <button type="submit">Login</button>
            </form>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
