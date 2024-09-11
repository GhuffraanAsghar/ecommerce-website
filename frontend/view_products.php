<?php
include '../components/connect.php';

// Initialize message arrays
$success_msg = [];
$warning_msg = [];

// Handling add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = htmlspecialchars($_POST['product_id']);
    $qty = (int)$_POST['qty']; // Ensure qty is an integer

    // Check if product is already in cart
    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE product_id = ?");
    $verify_cart->execute([$product_id]);

    if ($verify_cart->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        // Get product price
        $select_price = $conn->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        if ($fetch_price) {
            if ($qty > 0) {
                // Insert into cart
                try {
                    $insert_cart = $conn->prepare("INSERT INTO cart (product_id, price, qty) VALUES (?, ?, ?)");
                    $insert_cart->execute([$product_id, $fetch_price['price'], $qty]);
                    $success_msg[] = 'Product added to cart successfully';
                    header("Location: cart.php");
                    exit;
                } catch (PDOException $e) {
                    $warning_msg[] = 'Error adding product to cart: ' . htmlspecialchars($e->getMessage());
                }
            } else {
                $warning_msg[] = 'Invalid quantity specified.';
            }
        } else {
            $warning_msg[] = 'Product not found';
        }
    }
}

// Handling add to wishlist functionality
if (isset($_POST['add_to_wishlist'])) {
    $product_id = htmlspecialchars($_POST['product_id']);

    // Check if product is already in wishlist
    $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE product_id = ?");
    $verify_wishlist->execute([$product_id]);

    if ($verify_wishlist->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your wishlist';
    } else {
        try {
            // Insert into wishlist
            $insert_wishlist = $conn->prepare("INSERT INTO wishlist (product_id) VALUES (?)");
            $insert_wishlist->execute([$product_id]);
            $success_msg[] = 'Product added to wishlist successfully';
        } catch (PDOException $e) {
            $warning_msg[] = 'Error adding product to wishlist: ' . htmlspecialchars($e->getMessage());
        }
    }
}

// Display success and warning messages
if (!empty($success_msg)) {
    echo "<script>alert('". implode(", ", $success_msg) ."');</script>";
}

if (!empty($warning_msg)) {
    echo "<script>alert('". implode(", ", $warning_msg) ."');</script>";
}

// Fetch products with search functionality
$search_query = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$search_sql = $search_query ? "WHERE name LIKE :search OR product_details LIKE :search" : '';
$select_products = $conn->prepare("SELECT * FROM products $search_sql");
if ($search_query) {
    $select_products->execute(['search' => "%$search_query%"]);
} else {
    $select_products->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <script src="https://kit.fontawesome.com/05f313bbaf.js" crossorigin="anonymous"></script>
    <title>Green Coffee - Our Shop</title>
</head>
<body>
    <?php include "../components/header.php"; ?>

    <main class="main">
        <div class="banner">
            <h1>Shop</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a> / <span>Our Shop</span>
        </div>

        <section class="products">
            <div class="box-container">
                <?php
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        // Decode the JSON encoded images if stored as JSON
                        $images = json_decode($fetch_products['image'], true);

                        // Check if decoding is successful and images are available
                        if (is_array($images) && !empty($images)) {
                            $image = $images[0]; // Use the first image for display
                        } else {
                            $image = $fetch_products['image']; // Fallback if only one image
                        }
                ?>
                    <div class="product-box">
                        <a href="product.php?id=<?= htmlspecialchars($fetch_products['id']); ?>">
                            <img src="../frontend/img/<?= htmlspecialchars($image); ?>" class="product-image" alt="<?= htmlspecialchars($fetch_products['name']); ?>">
                            <h3 class="product-name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                        </a>
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                            <div class="product-details">
                                <p class="product-price">Price: $<?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                                <input type="number" name="qty" required min="1" value="1" max="99" class="quantity-input">
                            </div>
                            <div class="product-actions">
                                <button type="submit" name="add_to_cart" class="btn add-to-cart">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                                <button type="submit" name="add_to_wishlist" class="icon-button">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </form>
                    </div>        
                <?php
                    }
                } else {
                    echo '<p class="empty-message">No products found!</p>';
                }
                ?>
            </div>
        </section>
    </main>

    <?php include "../components/footer.php"; ?>
</body>
</html>
