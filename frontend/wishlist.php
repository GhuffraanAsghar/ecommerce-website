<?php
// Include database connection
include '../components/connect.php';

// Initialize message arrays
$success_msg = [];
$warning_msg = [];

// Remove product from wishlist
if (isset($_POST['remove_from_wishlist'])) {
    $product_id = htmlspecialchars($_POST['product_id']);
    
    // Delete the product from wishlist
    try {
        $remove_wishlist = $conn->prepare("DELETE FROM wishlist WHERE product_id = ?");
        $remove_wishlist->execute([$product_id]);
        $success_msg[] = 'Product removed from wishlist successfully';
    } catch (PDOException $e) {
        $warning_msg[] = 'Error removing product from wishlist: ' . htmlspecialchars($e->getMessage());
    }
}

// Add product to cart from wishlist
if (isset($_POST['add_to_cart_from_wishlist'])) {
    $product_id = htmlspecialchars($_POST['product_id']);
    $qty = (int)$_POST['qty']; // Ensure qty is an integer

    // Verify if product is already in cart
    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE product_id = ?");
    $verify_cart->execute([$product_id]);

    if ($verify_cart->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        // Get product price
        $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        if ($fetch_price) { // Check if the product exists
            if ($qty > 0) { // Ensure quantity is valid
                // Insert into cart
                try {
                    $insert_cart = $conn->prepare("INSERT INTO cart (product_id, price, qty) VALUES (?, ?, ?)");
                    $insert_cart->execute([$product_id, $fetch_price['price'], $qty]);
                    $success_msg[] = 'Product added to cart successfully';
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

// Fetch products from wishlist
$select_wishlist = $conn->prepare("SELECT * FROM wishlist");
$select_wishlist->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <script src="https://kit.fontawesome.com/05f313bbaf.js" crossorigin="anonymous"></script>
    <title>Green Coffee - Wishlist</title>
</head>
<body>
    <?php include "../components/header.php"; ?>

    <main class="main">
        <div class="banner">
            <h1>Your Wishlist</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a> / <span>Wishlist</span>
        </div>

        <section class="wishlist">
            <div class="box-container">
                <?php
                if ($select_wishlist->rowCount() > 0) {
                    while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                        // Fetch product details for each item in the wishlist
                        $product_id = $fetch_wishlist['product_id'];
                        $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
                        $select_product->execute([$product_id]);
                        $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
                        if ($fetch_product) {
                ?>
                    <form action="" method="post" class="wishlist-box">  
                        <img src="./img/<?= htmlspecialchars($fetch_product['image']); ?>" class="product-image" alt="<?= htmlspecialchars($fetch_product['name']); ?>">    
                        <h3 class="product-name"><?= htmlspecialchars($fetch_product['name']); ?></h3>
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_product['id']); ?>">
                        <div class="product-details">
                            <p class="product-price">Price: $<?= htmlspecialchars($fetch_product['price']); ?>/-</p>
                            <input type="number" name="qty" required min="1" value="1" max="99" class="quantity-input">
                        </div>
                        <div class="product-actions">
                            <button type="submit" name="add_to_cart_from_wishlist" class="btn add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <button type="submit" name="remove_from_wishlist" class="btn remove">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </form>        
                <?php
                        }
                    }
                } else {
                    echo '<p class="empty-message">Your wishlist is empty!</p>';
                }
                ?>
            </div>
        </section>
    </main>

    <?php include "../components/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    <!-- Display success and warning messages -->
    <?php if (!empty($success_msg)): ?>
        <script>
            swal("Success!", "<?= implode(", ", $success_msg); ?>", "success");
        </script>
    <?php endif; ?>

    <?php if (!empty($warning_msg)): ?>
        <script>
            swal("Warning!", "<?= implode(", ", $warning_msg); ?>", "warning");
        </script>
    <?php endif; ?>
</body>
</html>
