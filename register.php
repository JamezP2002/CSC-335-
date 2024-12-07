<?php
include 'sql/db_config.php'; // Include the database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_type = $_POST['user_type'];

    // Check if all fields are filled
    if (empty($username) || empty($email) || empty($password) || empty($user_type)) {
        $error_message = "All fields are required.";
    } else {
        // Sanitize inputs
        $username = $conn->real_escape_string($username);
        $email = $conn->real_escape_string($email);
        $user_type = $conn->real_escape_string($user_type);

        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username or email is already taken
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $error_message = "Username or email is already taken!";
        } else {
            // Insert new user into the database
            $sql = "INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $user_type);

            if ($stmt->execute()) {
                header("Location: login.php"); // Redirect to login page after successful registration
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
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
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <label for="user_type">Role:</label>
                <select id="user_type" name="user_type" required>
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
