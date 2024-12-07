<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="CDKeys For Me - The best deals on game keys for Black Friday and beyond!" />
    <title>CD Key Store</title>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <header class="main-header">
        <!-- Logo Section -->
        <div class="logo">
            <a href="index.php" title="Home - CDKeys For Me">
                <h1>CDKeys For Me</h1>
            </a>
            <span class="black-friday">Black Friday</span>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <form action="catalog.php" method="GET" role="search">
                <input 
                    type="text" 
                    name="query" 
                    placeholder="Search for products" 
                    aria-label="Search products"
                />
                <button type="submit" aria-label="Search">
                    <img 
                        src="images/search1.png" 
                        alt="Search Icon"
                    >
                </button>
            </form>
        </div>

        <!-- User Actions -->
        <div class="user-actions" aria-label="User and Cart">
            <a href="user.php" title="User Profile">
                <img 
                    src="images/circle-user-round.png" 
                    alt="User Profile"
                >
            </a>
            <a href="cart.php" title="Shopping Cart">
                <img 
                    src="images/shopping-basket.png" 
                    alt="Shopping Cart"
                >
            </a>
        </div>
    </header>
</body>
</html>
