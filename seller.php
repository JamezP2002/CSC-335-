<?php
session_start();
include 'sql/db_config.php'; // Include the database connection

// Check if the user is logged in and is a seller
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

// Handle form submission to add games
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $game_name = $_POST['game_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $cd_key = $_POST['cd_key'];

    // Handle file upload for cover art
    $cover_art = $_FILES['cover_art'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($cover_art['name']);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    if (isset($_POST["submit"])) {
        $check = getimagesize($cover_art["tmp_name"]);
        if ($check === false) {
            $upload_ok = 0;
            $error_message = "File is not an image.";
        }
    }

    // Allow only certain file formats
    if (!in_array($image_file_type, ['jpg', 'png', 'jpeg', 'gif'])) {
        $upload_ok = 0;
        $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    // Check file size (limit to 5MB)
    if ($cover_art["size"] > 5000000) {
        $upload_ok = 0;
        $error_message = "File is too large. Max size is 5MB.";
    }

    // Try to upload the file
    if ($upload_ok && move_uploaded_file($cover_art["tmp_name"], $target_file)) {
        // Insert the game into the database
        $game_name = $conn->real_escape_string($game_name);
        $price = $conn->real_escape_string($price);
        $cd_key = $conn->real_escape_string($cd_key);
        $cover_art_path = $conn->real_escape_string($target_file);

        $sql = "INSERT INTO games (name, cover_art, price, quantity, cd_key) VALUES ('$game_name', '$cover_art_path', '$price', '$cd_key')";
        if ($conn->query($sql) === TRUE) {
            $success_message = "Game added successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    } else {
        $error_message = $error_message ?? "There was an error uploading your file.";
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
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <h2>Add a New Game</h2>
            <?php if (isset($success_message)) { echo "<p style='color: green;'>$success_message</p>"; } ?>
            <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
            <form action="seller.php" method="POST" enctype="multipart/form-data">
                <label for="game_name">Game Name:</label>
                <input type="text" id="game_name" name="game_name" required>
                <br>
                <label for="cover_art">Cover Art:</label>
                <input type="file" id="cover_art" name="cover_art" accept="image/*" required>
                <br>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
                <br>
                <label for="cd_key">CD Key:</label>
                <textarea id="cd_key" name="cd_key" rows="3" required></textarea>
                <br>
                <button type="submit">Add Game</button>
            </form>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
