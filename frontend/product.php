<?php
// Establish connection from your existing connect.php file
include '../components/connect.php';

// Initialize message arrays
$success_msg = [];
$warning_msg = [];

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = htmlspecialchars($_GET['id']);

    // Prepare a SQL statement to fetch the product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);

    // Fetch the product
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Decode the JSON encoded images if stored as JSON
        $images = json_decode($product['image'], true); // Decode the JSON string into an array

        // Handling add to cart functionality
        if (isset($_POST['add_to_cart'])) {
            $qty = (int)$_POST['qty'];

            // Check if product is already in cart
            $verify_cart = $conn->prepare("SELECT * FROM cart WHERE product_id = ?");
            $verify_cart->execute([$product_id]);

            if ($verify_cart->rowCount() > 0) {
                $warning_msg[] = 'Product already exists in your cart';
            } else {
                if ($qty > 0) {
                    try {
                        // Insert into cart
                        $insert_cart = $conn->prepare("INSERT INTO cart (product_id, price, qty) VALUES (?, ?, ?)");
                        $insert_cart->execute([$product_id, $product['price'], $qty]);
                        $success_msg[] = 'Product added to cart successfully';
                    } catch (PDOException $e) {
                        $warning_msg[] = 'Error adding product to cart: ' . htmlspecialchars($e->getMessage());
                    }
                } else {
                    $warning_msg[] = 'Invalid quantity specified.';
                }
            }
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Your E-commerce Store</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style.css">
</head>
<body>

<?php include "../components/header.php"; ?>
    
<div class="main">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Carousel for displaying product images -->
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($images) && is_array($images)): ?>
                            <?php foreach ($images as $index => $image): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="../frontend/img/<?php echo htmlspecialchars($image); ?>" class="d-block w-100" alt="Product Image <?php echo $index + 1; ?>">
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="carousel-item active">
                                <img src="../frontend/img/default.jpg" class="d-block w-100" alt="Default Image">
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="lead mb-4">$<?php echo number_format($product['price'], 2); ?></p>
                <p class="mb-4"><?php echo nl2br(htmlspecialchars($product['product_details'])); ?></p>
                <form action="" method="post">
                    <div class="mb-4">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" name="qty" class="form-control" id="quantity" value="1" min="1" style="max-width: 100px;">
                    </div>
                    <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
                </form>
            </div>
        </div>

        

        

        <!-- Display success and warning messages -->
        <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success mt-4">
                <?= implode("<br>", $success_msg); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($warning_msg)): ?>
            <div class="alert alert-warning mt-4">
                <?= implode("<br>", $warning_msg); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "../components/footer.php"; // Include your existing footer ?>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
    } else {
        echo '<p>Product not found.</p>';
    }
} else {
    echo '<p>No product ID specified.</p>';
}
?>
