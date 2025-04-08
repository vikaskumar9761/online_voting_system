<?php
// Start the session to access session variables
session_start();

// Connect to the MySQL database
$conn = new mysqli('localhost', 'root', '', 'voting_system');

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Get the currently logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user details from the database using user ID
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();

// Check if the vote form is submitted
if (isset($_POST['vote'])) {
    // Get the selected candidate ID from the form
    $candidate_id = $_POST['candidate_id'];

    // Increase the selected candidate's vote count by 1
    $conn->query("UPDATE candidates SET votes = votes + 1 WHERE id = $candidate_id");

    // Mark the user as "voted" in the users table
    $conn->query("UPDATE users SET voted = 1 WHERE id = $user_id");

    // After voting, redirect back to the dashboard
    header('Location: dashboard.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - Online Voting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center mb-4">Welcome, <?= $user['name'] ?></h2>

        <div class="text-center mb-3">
            <?php if ($user['voted']) { ?>
                <span class="badge bg-success">Voted</span>
            <?php } else { ?>
                <span class="badge bg-warning text-dark">Not Voted</span>
            <?php } ?>
        </div>

        <?php if (!$user['voted']) { ?>
            <h4 class="text-center mb-3">Choose Your Candidate</h4>
            <div class="row">
                <?php
                $candidates = $conn->query("SELECT * FROM candidates");
                while ($candidate = $candidates->fetch_assoc()) {
                ?>
                    <div class="col-md-4 mb-3">
                        <div class="card p-3 text-center">
                            <h5><?= $candidate['name'] ?></h5>
                            <form method="post">
                                <input type="hidden" name="candidate_id" value="<?= $candidate['id'] ?>">
                                <button type="submit" name="vote" class="btn btn-primary btn-sm mt-2">Vote</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="text-center">
                <h4>Thank you for voting!</h4>
            </div>
        <?php } ?>

        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>
</body>
</html>
