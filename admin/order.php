<?php
include '../components/connect.php'; // Include the database connection

// Fetch all orders from the database
$orders = $conn->prepare("SELECT * FROM orders");
$orders->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <title>Manage Orders - Admin Dashboard</title>
</head>

<body>
<?php include "header.php"; ?>
    <div class="main">
        <h1 class="title">Manage Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Shipping Address</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each order and display in a table row
                while ($order = $orders->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$order['id']}</td>
                        <td>{$order['customer_name']}</td>
                        <td>{$order['customer_email']}</td>
                        <td>{$order['shipping_address']}</td>
                        <td>\${$order['total_amount']}</td>
                        <td>{$order['created_at']}</td>
                        <td>
                            <button class='btn'>View</button>
                            <button class='btn'>Edit</button>
                            <button class='btn'>Delete</button>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Display a message if there are no orders
        if ($orders->rowCount() === 0) {
            echo "<div class='empty'>No orders found.</div>";
        }
        ?>
    </div>

</body>

</html>
