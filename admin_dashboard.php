<?php
// Start the session to access session variables
session_start();

// Connect to the MySQL database
$conn = new mysqli('localhost', 'root', '', 'voting_system');

// Check if the user is not logged in or not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    // If not logged in as admin, redirect to login page
    header('Location: login.php');
    exit();
}

// Check if the delete request is set (when admin clicks delete)
if (isset($_GET['delete'])) {
    // Get the candidate ID to delete from the URL
    $id = $_GET['delete'];

    // Execute the query to delete the candidate from the database
    $conn->query("DELETE FROM candidates WHERE id=$id");

    // After deletion, redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel - Online Voting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center mb-4">Admin Panel</h2>

        <div class="mb-3 text-end">
            <a href="add_candidate.php" class="btn btn-success">Add Candidate</a>
            <a href="results.php" class="btn btn-info">View Results</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <h4>Candidates List</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Votes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $candidates = $conn->query("SELECT * FROM candidates");
                while ($candidate = $candidates->fetch_assoc()) {
                    echo "<tr>
                        <td>{$candidate['name']}</td>
                        <td>{$candidate['votes']}</td>
                        <td>
                            <a href='edit_candidate.php?id={$candidate['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='?delete={$candidate['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
