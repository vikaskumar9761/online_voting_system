<?php
// Start the session to access session variables
session_start();

// Connect to the MySQL database
$conn = new mysqli('localhost', 'root', '', 'voting_system');

// Check if the user is not logged in or is not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    // If not an admin, redirect to the login page
    header('Location: login.php');
    exit();
}

// Check if the form to add a new candidate is submitted
if (isset($_POST['add'])) {
    // Get the candidate name from the submitted form
    $name = $_POST['name'];

    // Insert the new candidate into the candidates table with 0 initial votes
    $conn->query("INSERT INTO candidates (name, votes) VALUES ('$name', 0)");

    // After adding, redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Candidate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow mx-auto" style="max-width: 400px;">
        <h2 class="text-center mb-4">Add New Candidate</h2>
        <form method="post">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Candidate Name" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary w-100">Add Candidate</button>
        </form>
    </div>
</div>
</body>
</html>
