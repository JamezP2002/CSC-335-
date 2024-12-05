<?php
session_start();
include 'sql/db_config.php'; // Include the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize inputs
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type']; // Role can be 'buyer' or 'seller'
        $_SESSION['user_id'] = $user['user_id']; // Store the user_id

        // Redirect based on user role
        if ($user['user_type'] === 'buyer') {
            header("Location: user.php"); // Redirect to buyer's user page
        } elseif ($user['user_type'] === 'seller') {
            header("Location: seller.php"); // Redirect to seller's page
        }
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
    <link rel="stylesheet" href="css/login.css">
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
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>