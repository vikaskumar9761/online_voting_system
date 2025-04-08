<?php
// Start the session to access session variables
session_start();

// Connect to the MySQL database
$conn = new mysqli('localhost', 'root', '', 'voting_system');

// Check if the user is not logged in or not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    // If not admin, redirect to login page
    header('Location: login.php');
    exit();
}

// Get the candidate ID from the URL parameter
$id = $_GET['id'];

// Fetch candidate details from the database based on ID
$candidate = $conn->query("SELECT * FROM candidates WHERE id=$id")->fetch_assoc();

// Check if the update form is submitted
if (isset($_POST['update'])) {
    $name = $_POST['name']; // Get the updated name from the form

    // Update the candidate name in the database
    $conn->query("UPDATE candidates SET name='$name' WHERE id=$id");

    // After update, redirect back to admin dashboard
    header('Location: admin_dashboard.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Candidate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow mx-auto" style="max-width: 400px;">
        <h2 class="text-center mb-4">Edit Candidate</h2>
        <form method="post">
            <div class="mb-3">
                <input type="text" name="name" value="<?= $candidate['name'] ?>" class="form-control" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Update Candidate</button>
        </form>
    </div>
</div>
</body>
</html>
