<?php
// Include database connection
include '../components/connect.php';

// Initialize message arrays
$success_msg = [];
$warning_msg = [];

// Fetch items from the cart for checkout
$select_cart = $conn->prepare("SELECT cart.id as cart_id, cart.qty, cart.price, products.name, products.image 
                               FROM cart 
                               JOIN products ON cart.product_id = products.id");
$select_cart->execute();

$grand_total = 0;
$cart_items = [];

if ($select_cart->rowCount() > 0) {
    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
        $sub_total = $fetch_cart['price'] * $fetch_cart['qty'];
        $grand_total += $sub_total;
        $cart_items[] = [
            'name' => htmlspecialchars($fetch_cart['name']),
            'price' => htmlspecialchars($fetch_cart['price']),
            'qty' => htmlspecialchars($fetch_cart['qty']),
            'sub_total' => $sub_total,
            'image' => htmlspecialchars($fetch_cart['image'])
        ];
    }
} else {
    $warning_msg[] = 'Your cart is empty!';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = htmlspecialchars($_POST['firstname']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $state = htmlspecialchars($_POST['state']);
    $zip = htmlspecialchars($_POST['zip']);
    $cardname = htmlspecialchars($_POST['cardname']);
    $cardnumber = htmlspecialchars($_POST['cardnumber']);
    $expmonth = htmlspecialchars($_POST['expmonth']);
    $expyear = htmlspecialchars($_POST['expyear']);
    $cvv = htmlspecialchars($_POST['cvv']);

    $order_processed = true; // Placeholder for demo
    if ($order_processed) {
        $insert_order = $conn->prepare("INSERT INTO orders (customer_name, customer_email, shipping_address, total_amount) VALUES (?, ?, ?, ?)");
        $insert_order->execute([$fullname, $email, $address, $grand_total]);
        $delete_cart = $conn->prepare("DELETE FROM cart");
        $delete_cart->execute();
        $success_msg[] = 'Thank you for your purchase. Your order has been placed.';
        header("Location: home.php"); // Redirect to home page
    } else {
        $warning_msg[] = 'There was an error processing your order. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <title>Checkout - Our Shop</title>
</head>
<body>
<?php include "../components/header.php"; ?>

<main class="main">
    <div class="banner text-center mb-4">
        <h1>Checkout</h1>
    </div>
    <div class="title2">
            <a href="cart.php">cart</a> / <span>checkout</span>
        </div>
    <div class="row">
        <div class="col-md-6">
            <form action="" method="post" class="mb-4">
                <h3>Billing Address</h3>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="firstname" placeholder="John M. Doe" required class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="john@example.com" required class="form-control">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="542 W. 15th Street" required class="form-control">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" placeholder="New York" required class="form-control">
                </div>
                <div class="row">
                    <div class="col">
                        <label>State</label>
                        <input type="text" name="state" placeholder="NY" required class="form-control">
                    </div>
                    <div class="col">
                        <label>Zip</label>
                        <input type="text" name="zip" placeholder="10001" required class="form-control">
                    </div>
                </div>
                <h3>Payment</h3>
                <div class="form-group">
                    <label class="card-info">Name on Card</label>
                    <input type="text" name="cardname" placeholder="John More Doe" required class="form-control">
                </div>
                <div class="form-group">
                    <label>Credit card number</label>
                    <input type="text" name="cardnumber" placeholder="1111-2222-3333-4444" required class="form-control">
                </div>
                <div class="row">
                    <div class="col">
                        <label>Exp Month</label>
                        <input type="text" name="expmonth" placeholder="September" required class="form-control">
                    </div>
                    <div class="col">
                        <label>Exp Year</label>
                        <input type="text" name="expyear" placeholder="2022" required class="form-control">
                    </div>
                    <div class="col">
                        <label>CVV</label>
                        <input type="text" name="cvv" placeholder="352" required class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn mt-4">Proceed to Checkout</button>
            </form>
        </div>
        <div class="col-md-6">
            <div class="order-summary">
                <h2>Your Order</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?= $item['name']; ?></td>
                            <td>$<?= $item['sub_total']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h4 class="text-right">Grand Total: $<?= $grand_total; ?></h4>
            </div>
        </div>
    </div>
</main>

<?php include "../components/footer.php"; ?>
</body>
</html>
