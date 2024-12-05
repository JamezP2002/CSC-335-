<?php
session_start();
include 'sql/db_config.php'; // Include the database connection

// Check if the user is logged in and is a seller
if (!isset($_SESSION['loggedin']) || $_SESSION['user_type'] !== 'seller') {
    header("Location: login.php");
    exit();
}

// Fetch available games for the dropdown
$games = [];
$sql = "SELECT game_id, game_title FROM games"; // Correct SQL query
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
}

// Handle form submission to add CD keys
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cd_key = $_POST['cd_key'];
    $game_id = $_POST['game_id']; // Changed to game_id to match the dropdown
    $price = $_POST['price'];
    $seller_id = $_SESSION['user_id']; // Use the logged-in seller's user ID
    $status = "available"; // Set status to "available"

    // Sanitize inputs
    $cd_key = $conn->real_escape_string($cd_key);
    $game_id = $conn->real_escape_string($game_id);
    $price = $conn->real_escape_string($price);

    // Insert the CD Key into the database
    $sql = "INSERT INTO CD_Keys (cd_key, game_id, seller_id, price, status) 
            VALUES ('$cd_key', '$game_id', '$seller_id', '$price', '$status')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "CD Key added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
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
    <link rel="stylesheet" href="css/seller.css">
    <title>Seller Dashboard</title>
</head>
<body>
    <div class="main-container">
        <main>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <h2>Add a New CD Key</h2>
            <?php if (isset($success_message)) { echo "<p style='color: green;'>$success_message</p>"; } ?>
            <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
            <form action="seller.php" method="POST">
                <label for="game_id">Select Game:</label>
                <select id="game_id" name="game_id" required>
                    <option value="" disabled selected>Select a game</option>
                    <?php foreach ($games as $game): ?>
                        <option value="<?= htmlspecialchars($game['game_id']); ?>"><?= htmlspecialchars($game['game_title']); ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
                <br>
                <label for="cd_key">CD Key:</label>
                <textarea id="cd_key" name="cd_key" rows="3" required></textarea>
                <br>
                <button type="submit">Add CD Key</button>
            </form>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
