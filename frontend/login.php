<?php
// Start the session
session_start();

// Include the database connection file
include '../components/connect.php';

$email = $password = '';
$email_err = $password_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check credentials
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, name, email, password FROM user WHERE email = :email"; // Use the correct table name 'user'

        if ($stmt = $conn->prepare($sql)) { // Use $conn from connect.php
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $name = $row["name"]; // Fetching name for future use
                        $hashed_password = $row["password"];

                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id; // Use user_id as per your registration logic
                            $_SESSION["user_name"] = $name; // Storing user name
                            $_SESSION["user_email"] = $email; // Storing user email
                            
                            // Redirect user to welcome page
                            header("location: home.php");
                            exit();
                        } else {
                            $password_err = "The password you entered is not valid.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        unset($stmt);
    }
    unset($conn);
}
?>

<style type="text/css">
    <?php include "../frontend/style.css"; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="login-main">
    <div class="title">
        <h2>Login</h2>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            <span class="error"><?php echo $email_err; ?></span>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <span class="error"><?php echo $password_err; ?></span>
        </div>
        <div class="login-btn">
            <button type="submit" class="btn">Login</button>
        </div>
        <p class="rig-p">Don't have an account? <a href="register.php">Register here</a>.</p>
    </form>
</div>

</body>
</html>
