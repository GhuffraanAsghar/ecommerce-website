<?php
// Include database connection
include '../components/connect.php';

// Initialize message arrays
$success_msg = [];
$warning_msg = [];

// Update quantity in cart
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];

    // Update the quantity in the cart
    $update_cart = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
    $update_cart->execute([$qty, $cart_id]);

    $success_msg[] = 'Cart updated successfully';

    // Redirect to cart page after updating
    header("Location: cart.php");
    exit;
}

// Remove product from cart
if (isset($_POST['remove_from_cart'])) {
    $cart_id = $_POST['cart_id'];

    // Delete the product from the cart
    $delete_cart = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $delete_cart->execute([$cart_id]);

    $success_msg[] = 'Product removed from cart';

    // Redirect to cart page after removing
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <script src="https://kit.fontawesome.com/05f313bbaf.js" crossorigin="anonymous"></script>
    <title>Green Coffee - Cart</title>
</head>
<body>
    <?php include "../components/header.php"; ?>

    <main class="main container py-5">
        <div class="banner">
            <h1>cart</h1>
        </div>
        <div class="title2">
            <a href="product.php">products</a> / <span>cart</span>
        </div>

        <section class="cart">
            <div class="row">
                <?php
                // Fetch items from the cart with product details
                $select_cart = $conn->prepare("SELECT cart.id as cart_id, cart.qty, cart.price, products.name, products.image 
                                               FROM cart 
                                               JOIN products ON cart.product_id = products.id");
                $select_cart->execute();

                $grand_total = 0;

                if ($select_cart->rowCount() > 0) {
                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        $sub_total = $fetch_cart['price'] * $fetch_cart['qty'];
                        $grand_total += $sub_total;

                        // Decode the JSON encoded images if stored as JSON
                        $images = json_decode($fetch_cart['image'], true);
                ?>
                    <div class="col-md-6 mb-4">
                        <form action="" method="post" class="card shadow-sm">
                            <div id="cartCarousel<?= $fetch_cart['cart_id']; ?>" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php if (!empty($images) && is_array($images)): ?>
                                        <?php foreach ($images as $index => $image): ?>
                                            <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                                <img src="../frontend/img/<?= htmlspecialchars($image); ?>" class="d-block w-100 cart-image" alt="Product Image <?= $index + 1; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="carousel-item active">
                                            <img src="../frontend/img/default.jpg" class="d-block w-100 cart-image" alt="Default Image">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <a class="carousel-control-prev" href="#cartCarousel<?= $fetch_cart['cart_id']; ?>" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#cartCarousel<?= $fetch_cart['cart_id']; ?>" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($fetch_cart['name']); ?></h5>
                                <input type="hidden" name="cart_id" value="<?= htmlspecialchars($fetch_cart['cart_id']); ?>">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p class="mb-0">Price: $<?= htmlspecialchars($fetch_cart['price']); ?>/-</p>
                                    <input type="number" name="qty" required min="1" value="<?= htmlspecialchars($fetch_cart['qty']); ?>" max="99" maxlength="2" class="form-control w-25 text-center">
                                </div>
                                <p class="text-right mb-0">Subtotal: $<?= htmlspecialchars($sub_total); ?>/-</p>
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="submit" name="update_cart" class="btn"><i class="bx bx-refresh"></i> Update Cart</button>
                                    <button type="submit" name="remove_from_cart" class="btn"><i class="bx bx-trash"></i> Remove</button>
                                </div>
                            </div>
                        </form>
                    </div>        
                <?php
                    }
                } else {
                    echo '<p class="text-center col-12">Your cart is empty!</p>';
                }
                ?>
            </div>

            <?php if ($grand_total > 0): ?>
                <div class="text-right">
                    <h3 class="grand-total">Grand Total: $<?= htmlspecialchars($grand_total); ?>/-</h3>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php include "../components/footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
