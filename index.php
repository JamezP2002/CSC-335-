<?php
// Include the header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css"> <!-- Link to the index-specific CSS -->
    <title>CDKeys Homepage</title>
</head>
<body>
    <div class="main-container">
        <main>
            <h1>Welcome to CDKeys For Me</h1>
            <p>Your one-stop shop for the best CD Key deals online. Start exploring now!</p>

            <!-- Image Carousel -->
            <div class="carousel">
                <div class="carousel-images">
                    <input type="radio" id="image1" name="carousel" checked>
                    <input type="radio" id="image2" name="carousel">
                    <input type="radio" id="image3" name="carousel">
                    <input type="radio" id="image4" name="carousel">

                    <div class="carousel-content">
                        <div class="carousel-item">
                            <img src="images\heart_of_chornobyl.jpg" alt="S.T.A.L.K.E.R. 2">
                        </div>
                        <div class="carousel-item">
                            <img src="images/minecraft.jpg" alt="Minecraft">
                        </div>
                        <div class="carousel-item">
                            <img src="images\sgvsvsfv.jpg" alt="Spider-Man Remastered">
                        </div>
                        <div class="carousel-item">
                            <img src="images\new_project_18_.jpg" alt="Days Gone">
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="carousel-navigation">
                        <label for="image1"></label>
                        <label for="image2"></label>
                        <label for="image3"></label>
                        <label for="image4"></label>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
