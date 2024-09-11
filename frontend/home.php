<?php
include '../components/connect.php';

session_start();
if (isset($_SESSION ['user_id'])) {
    $user_id = $_SESSION ['user_id'];
}
else {
    session_destroy();
    
}
?>
<style type="text/css">
    <?php include "../frontend/style.css" ?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <script src="https://kit.fontawesome.com/05f313bbaf.js" crossorigin="anonymous"></script>
    <title>Green Coffee - Home</title>
</head>
<body>
    <?php include "../components/header.php"; ?>
    <div class="main">
        <section class="home-section">
            <div class="slider">

                <!-- Slide 1 -->
                <div class="slider_slider slide1">
                    <div class="overlay">
                        <div class="slide-details">
                            <h1>Discover Our <br> Coffee Shop</h1>
                            <p>Experience our unique coffee shop experience</p>
                            <a href="product.php" class="btn">Shop Now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="slider_slider slide2">
                    <div class="overlay">
                        <div class="slide-details">
                            <h1>Discover Our <br> Coffee Shop</h1>
                            <p>Experience our unique coffee shop experience</p>
                            <a href="product.php" class="btn">Shop Now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="slider_slider slide3">
                    <div class="overlay">
                        <div class="slide-details">
                            <h1>Discover Our <br> Coffee Shop</h1>
                            <p>Experience our unique coffee shop experience</p>
                            <a href="product.php" class="btn">Shop Now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="slider_slider slide4">
                    <div class="overlay">
                        <div class="slide-details">
                            <h1>Discover Our <br> Coffee Shop</h1>
                            <p>Experience our unique coffee shop experience</p>
                            <a href="product.php" class="btn">Shop Now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                    </div>
                </div>

                <!-- Slide 5 -->
                <div class="slider_slider slide5">
                    <div class="overlay">
                        <div class="slide-details">
                            <h1>Discover Our <br> Coffee Shop</h1>
                            <p>Experience our unique coffee shop experience</p>
                            <a href="product.php" class="btn">Shop Now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <div class="left-arrow"><i class="fas fa-arrow-left"></i></div>
                <div class="right-arrow"><i class="fas fa-arrow-right"></i></div>

            </div>
        </section>
    
    <section class="thumb">
        <div class="box-container">
            <div class="box">
                <img src="./img//thumb2.jpg">
                <h3>Green tea</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod.</p>
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="box">
                <img src="./img/thumb0.jpg">
                <h3>Green coffee</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod.</p>
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="box">
                <img src="./img/thumb1.jpg">
                <h3>Green tea</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod.</p>
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="box">
                <img src="./img/thumb.jpg">
                <h3>Green coffee</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod.</p>
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
    </section>
    <section class="container">
        <div class="box-container">
            <div class="box">
                <img src="./img/about-us.png" alt="About Us">
            </div>
            <div class="box">
                <img src="./img/download.png" alt="Healthy Tea">
                <span>Healthy tea</span>
                <h1>save up to 50% off</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod.</p>
            </div>
        </div>
    </section>
    </div>
    <section class="shop">
        <div class="title">
            <img src="./img/download.png">
            <h1>Trending products</h1>
        </div>
        <div class="row">
            <img src="./img/about.jpg">
            <div class="row-detail">
                <img src="./img/basil.jpg">
                <div class="top-footer">
                    <h1>a cup of green tea makes you healthy</h1>
                </div>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <img src="./img/card.jpg">
                <a href="view_products.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="./img/card0.jpg">
                <a href="view_products.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="./img/card1.jpg">
                <a href="view_products.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="./img/card2.jpg">
                <a href="view_products.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="./img/10.jpg">
                <a href="view_products.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="./img/6.webp">
                <a href="view_products.php" class="btn">shop now</a>
            </div>
        </div>
    </section>
    
    <section class="services">
        <div class="box-container">
            <div class="box">
                <img src="./img/icon1.png">
                <h3>Great serving</h3>
                <p>save big every order</p>
            </div>
            <div class="box">
                <img src="./img/icon0.png">
                <h1>24/7 Support</h1>
                <p>one-one-one support</p>
            </div>
            <div class="box">
                <img src="./img/icon.png">
                <h1>gift vouchers</h1>
                <p>vouchers on every festival</p>
            </div>
        </div>
        
    </section>
    <section class="brand">
        <div class="box-container">
            <div class="box">
                <img src="./img/brand (1).jpg">
            </div>
            <div class="box">
                <img src="./img/brand (2).jpg">
            </div>
            <div class="box">
                <img src="./img/brand (3).jpg">
            </div>
            <div class="box">
                <img src="./img/brand (4).jpg">
            </div>
            <div class="box">
                <img src="./img/brand (5).jpg">
            </div>
        </div>
    </section>
    
    <?php include "../components/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./header.js"></script>
    <script src="./home.js"></script>

    <?php include '../components/alert.php'; ?>

</body>

</html>
