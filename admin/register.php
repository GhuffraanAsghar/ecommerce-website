<?php
include '../components/connect.php';

// Create table if it doesn't exist
$conn->exec("CREATE TABLE IF NOT EXISTS user (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('user', 'admin') NOT NULL DEFAULT 'user'
)");

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ""; 

// Register user
if(isset($_POST['submit'])){
    $id = unique_id(); // Assuming you have a function to generate unique IDs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
    $user_type = 'user'; // Default user type

    $select_user = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $select_user->execute([$email]);
    
    if($select_user->rowCount() > 0){
        echo "Email already exists";
    } else if($password != $cpass){
        echo "Passwords do not match";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_user = $conn->prepare("INSERT INTO user (id, name, email, password, user_type) VALUES (?, ?, ?, ?, ?)");
        $insert_user->execute([$id, $name, $email, $hashed_password, $user_type]);
        
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        
        echo "Registration successful";
    }
}
?>

<style type="text/css">
    <?php include "../frontend/style.css"; ?>
</style>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Tea - Register Now</title>
</head>
<body>

    <div class="rig-form-container">
        <div class="title">
            <img src="./img/download.png" alt="Green Tea Logo">
            <h1>Register Now</h1>
            <p class ="c-p" >Create an account to enjoy our free coffee, buy products, and more.</p>
        </div>
        <form action="" method="post" class="rig-form">
            <div class="input-group">
                <p>Your Name</p>
                <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="input-group">
                <p>Your Email</p>
                <input type="email" name="email" placeholder="Email" required oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <div class="input-group">
                <p>Enter Password</p>
                <input type="password" name="password" placeholder="Password" required oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <div class="input-group">
                <p>Confirm Password</p>
                <input type="password" name="cpass" placeholder="Confirm Password" required oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <div class="input-group">
                <input type="submit" name="submit" value="Register" class="btn">
            </div>
            <div class="input-group">
                <a href="login.php" class="btn">Already have an account? Login</a>
            </div>
        </form>
    </div>

</body>
</html>
