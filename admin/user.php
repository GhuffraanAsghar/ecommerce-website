<?php
include '../components/connect.php'; // Include the database connection

// Fetch all users from the database
$users = $conn->prepare("SELECT * FROM user");
$users->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Manage Users - Admin Dashboard</title>
</head>

<body>
<?php include "header.php"; ?>
    <div class="main container mt-5">
        <h1 class="title text-center mb-4">Manage Users</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each user and display in a table row
                    while ($user = $users->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['name']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['user_type']}</td>
                            <td>
                                <button class='btn btn-primary btn-sm'>View</button>
                                <button class='btn btn-warning btn-sm'>Edit</button>
                                <button class='btn btn-danger btn-sm'>Delete</button>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
        // Display a message if there are no users
        if ($users->rowCount() === 0) {
            echo "<div class='alert alert-info text-center'>No users found.</div>";
        }
        ?>
    </div>

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
