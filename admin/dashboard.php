<?php
include '../components/connect.php'; // Include the database connection

// Fetch total users
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM user")->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch total orders
$totalOrders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch total products
$totalProducts = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch total earnings per order date
$earningsQuery = $conn->query("SELECT DATE(created_at) as order_date, SUM(total_amount) as total_earnings FROM orders GROUP BY DATE(created_at) ORDER BY order_date ASC");
$earnings = $earningsQuery->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the graph
$orderDates = array_column($earnings, 'order_date');
$totalEarnings = array_column($earnings, 'total_earnings');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../admin/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">

    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="main container mt-5">
        <h1 class="title text-center mb-4">Admin Dashboard</h1>

        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text display-4"><?= $totalUsers ?></p>
                        <a href="user.php" class="btn">View Users</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text display-4"><?= $totalOrders ?></p>
                        <a href="order.php" class="btn">View Orders</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <p class="card-text display-4"><?= $totalProducts ?></p>
                        <a href="add-products.php" class="btn">View Products</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Earnings</h5>
                        <p class="card-text display-4">$<?= number_format(array_sum($totalEarnings), 2) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Total Earnings by Date</h5>
                <canvas id="earningsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Earnings chart data
        const ctx = document.getElementById('earningsChart').getContext('2d');
        const earningsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($orderDates) ?>,
                datasets: [{
                    label: 'Total Earnings by Date',
                    data: <?= json_encode($totalEarnings) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Earnings ($)'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
