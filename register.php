<?php
// Connect to the MySQL database
$conn = new mysqli('localhost', 'root', '', 'voting_system');

// Check if the registration form is submitted
if (isset($_POST['register'])) {
    $name = $_POST['name']; // Get the entered name from form
    $email = $_POST['email']; // Get the entered email from form

    // Hash the password for security before saving it to the database
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert the new user into the users table
    $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

    // After successful registration, redirect to the login page
    header('Location: login.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Online Voting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow mx-auto" style="max-width: 400px;">
        <h2 class="text-center mb-4">Create Account</h2>
        <form method="post">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</div>
</body>
</html>
