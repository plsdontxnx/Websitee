<?php
session_start(); // Start session
include("connect.php"); // Include database connection
include("header.php");
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
</head>
<body>

<section class="container" id="home">
  <!-- Text Section -->
  <div class="text-section">
    <h1><span class="highlight"> GOffe</span></h1>
    <p>
      Elevating your cravings with every order. Discover the perfect mix of flavor, 
      convenience, and delight, delivered straight to you for an unforgettable experience!
    </p>
    <button class="order-btn">Order Now</button>
  </div>

  <!-- Image Carousel Section -->
  <div class="carousel-section">
    <div class="carousel">
      <div class="carousel-images">
        <img src="images/matcha.jpg" alt="Match Coffee" class="carousel-image" onclick="openCarousel(0)">
        <img src="images/sample.jpg" alt="Sample Coffee" class="carousel-image" onclick="openCarousel(1)">
        <img src="images/shopPic.jpg" alt="Shop Picture" class="carousel-image" onclick="openCarousel(2)">
        <img src="images/frontpic.jpg" alt="Shop Picture" class="carousel-image" onclick="openCarousel(3)">
      </div>
    </div>
  </div>
</section>

<!-- Modal for Image View -->
<div id="imageModal" class="modal">
  <span class="close" onclick="closeModal()">×</span>
  <div class="modal-content">
    <img id="modalImage" src="" alt="Expanded Image">
  </div>
  <div class="modal-nav">
    <button class="prev" onclick="changeImage(-1)">&#10094;</button>
    <button class="next" onclick="changeImage(1)">&#10095;</button>
  </div>
</div>

<style>
  /* General Styles */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  /* Home Section */
  #home {
    padding: 50px 0;
    background-color: #f9f1e8;
  }

  .text-section {
    text-align: center;
    margin-bottom: 30px;
  }

  .text-section h1 {
    font-size: 3rem;
    color: #d58c45;
  }

  .highlight {
    color: #d58c45;
  }

  .text-section p {
    font-size: 1.2rem;
    color: #333;
    margin: 20px 0;
  }

  .order-btn {
    font-size: 1.2rem;
    padding: 10px 25px;
    border: none;
    background-color: #d58c45;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .order-btn:hover {
    background-color: #b47834;
  }

  /* Carousel Section */
  .carousel-section {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    padding-top: 50px;
  }

  .carousel {
    display: flex;
    justify-content: center;
    width: 100%;
    max-width: 1200px;
    gap: 10px;
    position: relative;
    overflow: hidden;
  }

  .carousel-images {
    display: flex;
    gap: 15px;
  }

  .carousel-image {
    width: 100%;
    max-width: 500px;
    height: auto;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .carousel-image:hover {
    transform: scale(1.05);
  }

  /* Modal Styles */
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    overflow: auto;
  }

  .modal-content {
    position: relative;
    top: 10%;
    margin: auto;
    max-width: 90%;
    max-height: 80%;
  }

  .modal-content img {
    width: 100%;
    height: auto;
    border-radius: 10px;
  }

  .modal-nav {
    position: absolute;
    top: 50%;
    width: 100%;
    display: flex;
    justify-content: space-between;
  }

  .modal-nav button {
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    font-size: 2rem;
  }

  .modal-nav button:hover {
    background-color: rgba(0, 0, 0, 0.7);
  }

  .close {
    position: absolute;
    top: 10px;
    right: 25px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
  }

  /* Media Queries for Responsiveness */
  @media (max-width: 1200px) {
    .text-section h1 {
      font-size: 2.5rem;
    }

    .text-section p {
      font-size: 1.1rem;
    }

    .order-btn {
      font-size: 1.1rem;
      padding: 8px 20px;
    }

    .carousel {
      max-width: 100%;
    }
  }

  @media (max-width: 768px) {
    .carousel-image {
      max-width: 100%;
      height: auto;
    }

    .text-section h1 {
      font-size: 2rem;
    }

    .text-section p {
      font-size: 1rem;
    }

    .order-btn {
      font-size: 1rem;
      padding: 8px 15px;
    }
  }

  @media (max-width: 576px) {
    .text-section h1 {
      font-size: 1.5rem;
    }

    .text-section p {
      font-size: 0.9rem;
    }

    .order-btn {
      font-size: 1rem;
      padding: 8px 15px;
    }
  }
</style>

<script>
  let currentIndex = 0;
  const images = document.querySelectorAll('.carousel-image');

  function openCarousel(index) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modal.style.display = "block";
    modalImage.src = images[index].src;
    currentIndex = index;
  }

  function closeModal() {
    document.getElementById('imageModal').style.display = "none";
  }

  function changeImage(direction) {
    currentIndex = (currentIndex + direction + images.length) % images.length;
    document.getElementById('modalImage').src = images[currentIndex].src;
  }
</script>





    <section class="section-two" id="menu">
    <style>
        /* General Styles for the Menu Section */
        .section-two {
            padding: 40px 20px;
            background-color: #f9f1e8;
            text-align: center;
            width: 100%; /* Ensure full width */
        }

        .flavors-section h2 {
            color: #d58c45;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .flavors-container {
            display: flex;
            flex-wrap: wrap; /* Enables wrapping of items */
            justify-content: center; /* Centers the items */
            gap: 20px; /* Space between items */
            margin-top: 20px;
            width: 100%; /* Ensure full width of the container */
        }

        .flavor-item {
            flex: 1 1 30%; /* Flexible width with minimum 30% per item */
            max-width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box; /* Prevents overflow */
        }

        .flavor-item:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }

        .flavor-item img {
            max-width: 100%; /* Ensures images scale properly */
            height: auto;
            margin-bottom: 10px;
        }

        .flavor-item p {
            font-size: 1rem;
            color: #333;
            margin-top: 10px;
        }

        /* Responsive Adjustments */
        @media screen and (max-width: 1024px) {
            .flavor-item {
                flex: 1 1 45%; /* Adjust to two items per row on medium screens */
            }
        }

        @media screen and (max-width: 768px) {
            .flavor-item {
                flex: 1 1 45%; /* Two items per row on smaller screens */
            }
        }

        @media screen and (max-width: 480px) {
            .flavor-item {
                flex: 1 1 100%; /* Stack items vertically on very small screens */
                max-width: none; /* Remove the max width for small screens */
            }
        }
    </style>

    <div class="flavors-section">
        <h2>Explore Our Flavors</h2>
        <div class="flavors-container">
            <!-- Iced Coffee -->
            <div class="flavor-item">
                <a href="iced-coffee.php" target="_blank">
                    <img src="images/iced coffe.png" alt="Iced Coffee" class="center-iced">
                </a>
                <p>Iced Coffee</p>
            </div>

            <!-- Meals -->
            <div class="flavor-item middle-box">
                <a href="meals.php" target="_blank">
                    <img src="images/pasta.png" alt="Meals" class="center-pasta">
                </a>
                <p>Meals</p>
            </div>

            <!-- Non-Coffee -->
            <div class="flavor-item third-box">
                <a href="non-coffee.php" target="_blank">
                    <img src="images/matcha.webp" alt="Non-Coffee">
                </a>
                <p>Non-Coffee</p>
            </div>
        </div>
    </div>
</section>



    <!-- About Us Section -->
    <section id="about" class="about-us" style="background-color: #f9f1e8; padding: 40px 20px; text-align: center;">
        <h2 style="color: #d58c45; font-size: 2rem; margin-bottom: 20px;">About Us</h2>
        <p style="color: #333; font-size: 1rem; max-width: 800px; margin: 0 auto;">
            At GOffe, we value the art of crafting the perfect cup of coffee and offering delightful meals. 
            Every bean and ingredient is hand-selected to ensure quality and freshness. 
            Our team is committed to sustainability and community growth by sourcing locally 
            and maintaining a positive experience for every customer.
        </p>
    </section>

    <!-- Contact Us Section -->
    <section id="contact" class="contact-us" style="background-color: #fff; padding: 40px 20px; text-align: center; border-top: 2px solid #d58c45;">
        <h2 style="color: #d58c45; font-size: 2rem; margin-bottom: 20px;">Contact Us</h2>
        <p style="color: #333; font-size: 1rem; margin-bottom: 10px;">
            We'd love to hear from you! Whether you have inquiries, feedback, or collaboration ideas, you can reach out to us using the information below:
        </p>
        <ul style="list-style: none; padding: 0; color: #333; font-size: 1rem; margin-bottom: 20px;">
            <li>Email: <a href="mailto:support@goffe.com" style="color: #d58c45; text-decoration: none;">support@goffe.com</a></li>
            <li>Phone: <a href="tel:+15551234567" style="color: #d58c45; text-decoration: none;">(555) 123-4567</a></li>
            <li>Address: 123 GOffe Lane, Coffeeville, USA</li>
        </ul>
        <p style="color: #333; margin-bottom: 10px; text-align: center;">Follow us on social media channels for news and updates:</p>
        <ul style="list-style: none; padding: 0; display: flex; justify-content: center; align-items: center;">
            <li style="margin-right: 15px;">
                <a href="#" style="color: #d58c45; text-decoration: none; font-size: 24px;">
                    <i class="fab fa-instagram"></i>
                </a>
            </li>
            <li style="margin-right: 15px;">
                <a href="#" style="color: #d58c45; text-decoration: none; font-size: 24px;">
                    <i class="fab fa-facebook"></i>
                </a>
            </li>
            <li>
                <a href="#" style="color: #d58c45; text-decoration: none; font-size: 24px;">
                    <i class="fab fa-twitter"></i>
                </a>
            </li>
        </ul>
    </section>

    <!-- Footer Section -->
    <footer style="background-color: #f9f1e8; padding: 20px 0; text-align: center; font-size: 0.9rem; color: #333;">
        <p>© GOffe</p>
        <p style="margin-top: 10px;">Disclaimer: This website and its content are part of a school project and for educational purposes only.</p>
    </footer>

    <!-- JavaScript Logic -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const orderButton = document.getElementById("orderButton");
            const carousel = document.querySelector('.carousel-images');
            let currentIndex = 0;
            const images = carousel.querySelectorAll('img');

            function showImage(index) {
                // Hide all images first
                images.forEach(img => img.style.display = 'none');
                images[index].style.display = 'block';
            }

            function nextImage() {
                currentIndex = (currentIndex + 1) % images.length;
                showImage(currentIndex);
            }

            // Automatic carousel functionality
            setInterval(nextImage, 3000); // Change image every 3 seconds

            // Initially show the first image
            showImage(currentIndex);

            orderButton.addEventListener("click", function () {
                const loggedIn = orderButton.dataset.loggedIn === 'true';
                if (loggedIn) {
                    document.getElementById("menu").scrollIntoView({ behavior: "smooth" });
                } else {
                    window.location.href = "login.php";
                }
            });
        });
    </script>

</body>
</html>

