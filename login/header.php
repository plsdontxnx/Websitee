<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session if not already started
}
include("connect.php"); // Include database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goffee</title>

    <!-- Linking CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Angkor&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
         body {
            font-family: 'Poppins', sans-serif;
        }
        .goffee-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #cfbaa2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for visual effect */
        }

        .goffee-nav .logo a {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            color: rgb(197, 108, 19);
        }

        .goffee-nav .logo img {
            margin-right: 10px;
            width: 40px;
            height: 40px;
        }

        .goffee-nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .goffee-nav ul li {
            margin-left: 20px;
        }

        .goffee-nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .goffee-nav ul li a:hover {
            color: #c6a686;
        }

        /* Hamburger Menu Styles */
        .goffee-nav .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .goffee-nav .hamburger span {
            background-color: #333;
            height: 3px;
            width: 25px;
            margin: 3px 0;
        }

        /* Responsive Menu */
        @media (max-width: 768px) {
            .goffee-nav .hamburger {
                display: flex;
            }

            .goffee-nav ul {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                right: 0;
                background-color: #cfbaa2;
                width: 100%;
                text-align: center;
                padding: 10px 0;
            }

            .goffee-nav ul.active {
                display: flex;
            }

            .goffee-nav ul li {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Section -->
    <nav class="goffee-nav">
        <div class="logo">
            <a href="index.php">
                <img src="images/cafe logo.png" alt="Cafe Logo">
                <span><span class="go">GO</span><span class="fee">ffee</span></span>
            </a>
        </div>

        <!-- Hamburger Menu -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Navigation Links -->
        <ul id="nav-links">
            <li><a href="index.php#home" class="nav-link">Home</a></li>
            <li><a href="index.php#menu" class="nav-link">Menu</a></li>
            <li><a href="index.php#about" class="nav-link">About Us</a></li>
            <li><a href="index.php#contact" class="nav-link">Contact</a></li>
            <li>
                <a href="product-details.php">
                    <img src="images/shopping-cart.png" alt="Shopping Cart" style="width: 20px;">
                </a>
            </li>
            <?php if (isset($_SESSION['email']) && isset($_SESSION['fName'])): ?>
                <li><a href="UserProfile.php">Hello, <?php echo htmlspecialchars($_SESSION['fName']); ?>!</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Sign In</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- JavaScript for Hamburger Toggle -->
    <script>
        const hamburger = document.getElementById("hamburger");
        const navLinks = document.getElementById("nav-links");

        hamburger.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
    </script>

</body>
</html>
