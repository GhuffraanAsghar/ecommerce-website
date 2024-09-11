<?php
include '../components/connect.php'; // Include the database connection

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $name = $_POST['name'];
    $product_details = $_POST['product_details'];
    $price = $_POST['price'];

    // Handle the image upload
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Define allowed file types
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

    // Validate image upload
    if (in_array($imageExt, $allowedExts) && $imageError === 0 && $imageSize < 2000000) { // Limit size to 2MB
        // Generate a unique filename
        $imageNewName = uniqid('', true) . "." . $imageExt;
        $imageDestination = '../frontend/img/' . $imageNewName; // Ensure this directory exists

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($imageTmpName, $imageDestination)) {
            // Prepare the SQL statement to insert the product
            $insert_product = $conn->prepare("INSERT INTO products (name, product_details, image, price) VALUES (?, ?, ?, ?)");
            $insert_product->execute([$name, $product_details, $imageNewName, $price]); // Execute the insert

            // Redirect or display a success message
            echo "<script>alert('Product added successfully!'); window.location.href='./add-products.php';</script>";
        } else {
            echo "<script>alert('Failed to move uploaded file.');</script>";
        }
    } else {
        echo "<script>alert('Invalid image upload! Please upload a JPG, PNG, or GIF file less than 2MB.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../frontend/style.css">
    <title>Add Product - Green Coffee</title>
</head>

<body>
<?php include "header.php"; ?>

    <div class="main">
        <h1>Add New Product</h1>
        <form action="" method="post" enctype="multipart/form-data"> <!-- Added enctype -->
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" accept=".jpg, .jpeg, .png, .gif" required> <!-- File input -->
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" step="0.01" required>
            </div>
            <input type="submit" name="submit" value="Add Product" class="btn">
        </form>
    </div>

</body>

</html>
