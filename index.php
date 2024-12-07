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
            <!-- Hero Section -->
            <section class="hero">
                <h1>Welcome to CDKeys For Me</h1>
                <p>Your one-stop shop for the best CD Key deals online. Start exploring now!</p>
                <a href="catalog.php" class="explore-btn">Browse All Games</a>
            </section>

            <!-- Featured Section -->
            <section class="featured">
                <h2>Featured Games</h2>
                <div class="showcase">
                    <div class="game-card">
                        <img src="images/heart_of_chornobyl.jpg" alt="S.T.A.L.K.E.R. 2">
                        <h3>S.T.A.L.K.E.R. 2</h3>
                    </div>
                    <div class="game-card">
                        <img src="images/minecraft.jpg" alt="Minecraft">
                        <h3>Minecraft</h3>
                    </div>
                    <div class="game-card">
                        <img src="images/spider-man.jpg" alt="Spider-Man Remastered">
                        <h3>Spider-Man Remastered</h3>
                    </div>
                    <div class="game-card">
                        <img src="images/days_gone.jpg" alt="Days Gone">
                        <h3>Days Gone</h3>
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section class="testimonials">
                <h2>What Our Customers Say</h2>
                <div class="testimonial-card">
                    <p>"CDKeys For Me is the best! I saved so much on my favorite games."</p>
                    <span>- Alex J.</span>
                </div>
                <div class="testimonial-card">
                    <p>"Fast, reliable, and unbeatable prices. Highly recommended!"</p>
                    <span>- Sarah W.</span>
                </div>
                <div class="testimonial-card">
                    <p>"Amazing deals and a huge collection of games. I love it!"</p>
                    <span>- Michael T.</span>
                </div>
            </section>

            <!-- Call-to-Action Section -->
            <section class="cta">
                <h2>Start Saving on Your Favorite Games</h2>
                <p>Sign up today and get exclusive discounts on top titles.</p>
                <a href="register.php" class="cta-btn">Join Now</a>
            </section>
        </main>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
