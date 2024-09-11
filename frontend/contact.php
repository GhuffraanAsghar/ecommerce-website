<?php
include '../components/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <script src="https://kit.fontawesome.com/05f313bbaf.js" crossorigin="anonymous"></script>
    <title>Green Coffee - Contact Us</title>
</head>
<body>
    <?php include "../components/header.php"; ?>

    <div class="main">
        <div class="banner">
            <h1>Contact Us</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a> / <span>Contact us</span>
        </div>

        <section class="services">
            <div class="box-container">
                <div class="box">
                    <img src="./img/icon1.png" alt="Great serving">
                    <h3>Great serving</h3>
                    <p>Save big every order</p>
                </div>
                <div class="box">
                    <img src="./img/icon0.png" alt="24/7 Support">
                    <h1>24/7 Support</h1>
                    <p>One-on-one support</p>
                </div>
                <div class="box">
                    <img src="./img/icon.png" alt="Gift vouchers">
                    <h1>Gift Vouchers</h1>
                    <p>Vouchers on every festival</p>
                </div>
            </div>
        </section>

        <section class="contact-form">
            <h2>We'd love to hear from you!</h2>
            <form action="contact_process.php" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit" class="btn">Send Message</button>
            </form>
        </section>
    </div>

    <?php include "../components/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./scripts/java.js"></script>
    <?php include '../components/alert.php'; ?>
</body>

</html>
