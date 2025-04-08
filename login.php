<?php
session_start(); // Start a new session or resume the existing session
$conn = new mysqli('localhost', 'root', '', 'voting_system'); // Connect to the MySQL database

// Set fixed admin email and password
$admin_email = "admin@gmail.com"; 
$admin_password = "admin@123"; // You can change this to a stronger password

// Check if the login form is submitted
if (isset($_POST['login'])) {
    $email = $_POST['email']; // Get the entered email
    $password = $_POST['password']; // Get the entered password

    // First, check if the login is for admin
    if ($email == $admin_email && $password == $admin_password) {
        $_SESSION['user_id'] = 'admin'; // Set session user_id as 'admin'
        $_SESSION['role'] = 'admin'; // Set session role as 'admin'
        header('Location: admin_dashboard.php'); // Redirect to admin dashboard
        exit(); // Stop further script execution
    }

    // If not admin, check the database for normal user
    $result = $conn->query("SELECT * FROM users WHERE email='$email'"); // Fetch user by email
    $user = $result->fetch_assoc(); // Get user data as associative array

    // If user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Set session user_id from database
        $_SESSION['role'] = $user['role']; // Set session role (user/admin from database)
        header('Location: dashboard.php'); // Redirect to user dashboard
    } else {
        $error = "Invalid email or password."; // Set error message if login fails
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Online Voting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow mx-auto" style="max-width: 400px;">
        <h2 class="text-center mb-4">Login</h2>
        <?php if (!empty($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <form method="post">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</div>
</body>
</html>
