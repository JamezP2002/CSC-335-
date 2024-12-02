<?php
include 'sql/db_config.php'; // Include the database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Sanitize inputs
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password); // Store password as plain text
    $role = $conn->real_escape_string($role);

    // Check if the username is already taken
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $error_message = "Username is already taken!";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php"); // Redirect to login page after successful registration
            exit();
        } else {
            $error_message = "Error: " . $conn->error;
        }
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
    <link rel="stylesheet" href="css/register.css">
    <title>Register</title>
</head>
<body>
    <div class="main-container">
        <main>
            <h1>Register</h1>
            <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
            <form action="register.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                </select>
                <br>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
