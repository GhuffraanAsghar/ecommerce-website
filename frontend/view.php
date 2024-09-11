<?php
include '../components/connect.php';

// Initialize message arrays
$success_msg = [];
$warning_msg = [];

// Check if there is a search query
$search_query = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Prepare the SQL statement to fetch products, filtered by the search query if present
$search_sql = $search_query ? "WHERE name LIKE :search OR product_details LIKE :search" : '';
$select_products = $conn->prepare("SELECT * FROM products $search_sql");
if ($search_query) {
    $select_products->execute(['search' => "%$search_query%"]);
} else {
    $select_products->execute();
}

// Fetch the products
$products = $select_products->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Green Coffee</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <script src="https://kit.fontawesome.com/05f313bbaf.js" crossorigin="anonymous"></script>
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

    <!-- Search Form -->
    <section class="search-bar">
        <form id="search-form" class="search-form" action="shop.php" method="get">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search products..." aria-label="Search" class="form-control" style="max-width: 300px; display: inline-block;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
        </form>
    </section>

    <section class="products mt-4">
        <div class="box-container">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <?php
                    // Decode the JSON encoded images if stored as JSON
                    $images = json_decode($product['image'], true);

                    // Use the first image for display or fallback to single image if decoding fails
                    $image = is_array($images) && !empty($images) ? $images[0] : $product['image'];
                    ?>
                    <div class="product-box">
                        <a href="product.php?id=<?= htmlspecialchars($product['id']); ?>">
                            <img src="../frontend/img/<?= htmlspecialchars($image); ?>" class="product-image" alt="<?= htmlspecialchars($product['name']); ?>">
                            <h3 class="product-name"><?= htmlspecialchars($product['name']); ?></h3>
                        </a>
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                            <div class="product-details">
                                <p class="product-price">Price: $<?= htmlspecialchars($product['price']); ?>/-</p>
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
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-message">No products found! Try searching with different keywords.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include "../components/footer.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="../frontend/search.js"></script>
</body>
</html>
