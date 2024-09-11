<?php
include '../components/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <script src="https://kit.fontawesome.com/05f313bbaf.js" crossorigin="anonymous"></script> <!-- FontAwesome CDN -->
</head>
<body>
    <?php include "../components/header.php"; ?>
    <div class="main">
        <div class="banner">
            <h1>About Us</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a>   /   <span>About</spa>
        </div>
    </div>    
    <div class="about-category">
        <div class="box">
            <img src="./img/3.webp" alt="Lemon Green Tea">
            <div class="detail">
                <span>Coffee</span>
                <h1>Lemon Green</h1>
                <a href="view_products.php" class="btn">Shop Now .</i></a> <!-- Added icon -->
            </div>
        </div>
        <div class="box">
            <img src="./img/about.png" alt="Lemon Teaname">
            <div class="detail">
                <span>Coffee</span>
                <h1>Lemon Teaname</h1>
                <a href="view_products.php" class="btn">Shop Now .</i></a> <!-- Added icon -->
            </div>
        </div>
        <div class="box">
            <img src="./img/1.webp" alt="Lemon Green">
            <div class="detail">
                <span>Coffee</span>
                <h1>Lemon Green</h1>
                <a href="view_products.php" class="btn">Shop Now .</i></a> <!-- Added icon -->
            </div>
        </div>
    </div>
    <section class="services">
        <div class="title">
            <img src="./img/download.png" class="logo" alt="Logo">
            <h1>Why Choose Us</h1>
            <p>Our coffee shop has been serving coffee since 2010.</p>
        <div class="box-container">
            <div class="box">
                <i class="fas fa-coffee"></i> <!-- Replaced image with FontAwesome icon -->
                <h3>Great Serving</h3>
                <p>Save big on every order</p>
            </div>
            <div class="box">
                <i class="fas fa-headset"></i> <!-- Replaced image with FontAwesome icon -->
                <h1>24/7 Support</h1>
                <p>One-on-one support</p>
            </div>
            <div class="box">
                <i class="fas fa-gift"></i> <!-- Replaced image with FontAwesome icon -->
                <h1>Gift Vouchers</h1>
                <p>Vouchers on every festival</p>
            </div>
        </div>
    </section>
    <div class="about">
        <div class="row">
            <div class="img-box">
                <img src="./img/3.png" alt="Showroom">
            </div>
            <div class="details">
                <h1>Visit Our Beautiful Showroom</h1>
                <p>Welcome to our beautiful showroom, where you can explore our premium selection of green teas. Each blend is carefully curated to offer a perfect balance of flavor and wellness benefits. Step inside and experience the art of tea, from the vibrant green hues to the soothing aromas, all in a space designed to inspire tranquility and well-being. Whether you're a tea enthusiast or new to the world of green tea, our showroom provides the perfect setting to discover your next favorite blend.</p>
                <a href="view_products.php" class="btn">Shop Now .</i></a> <!-- Added icon -->
            </div>
        </div>
        <div class="testimonial-container">
            <div class="title">
                <img src="./img/download.png" class="logo" alt="Logo">
                <h2>What People Say About Us</h2>
                <p>Our coffee shop has been serving coffee since 2010.</p>
            </div>
            <div class="container">
                <div class="testimonial-item active">
                    <img src="./img/01.jpg" alt="Testimonial from Ghuffraan Asghar">
                    <h1>salina</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel enim sit amet est pharetra condimentum. Donec vel tristique urna. Duis convallis, justo nec dictum elementum, nulla velit faucibus felis, ut pulvinar ex nisi vel neque.</p>
                </div>
                <div class="testimonial-item">
                    <img src="./img/02.jpg" alt="Testimonial from Sbhan Mughal">
                    <h1>Sbhan Mughal</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel enim sit amet est pharetra condimentum. Donec vel tristique urna. Duis convallis, justo nec dictum elementum, nulla velit faucibus felis, ut pulvinar ex nisi vel neque.</p>
                </div>
                <div class="testimonial-item">
                    <img src="./img/03.jpg" alt="Testimonial from Usman Chaudry">
                    <h1>Usman Chaudry</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel enim sit amet est pharetra condimentum. Donec vel tristique urna. Duis convallis, justo nec dictum elementum, nulla velit faucibus felis, ut pulvinar ex nisi vel neque.</p>
                </div>
                <div class="left-arrow" onclick="prevSlide()"><i class="fas fa-chevron-left"></i></div> <!-- Replaced with FontAwesome icon -->
                <div class="right-arrow" onclick="nextSlide()"><i class="fas fa-chevron-right"></i></div> <!-- Replaced with FontAwesome icon -->
            </div>
        </div>
    </div>
    <?php include "../components/footer.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./testimonials_slider.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
