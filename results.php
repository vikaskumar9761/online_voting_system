<?php
$conn = new mysqli('localhost', 'root', '', 'voting_system');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Voting Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center mb-4">Voting Results</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $candidates = $conn->query("SELECT * FROM candidates ORDER BY votes DESC");
                while ($candidate = $candidates->fetch_assoc()) {
                    echo "<tr>
                        <td>{$candidate['name']}</td>
                        <td>{$candidate['votes']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="text-center mt-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Admin Panel</a>
        </div>
    </div>
</div>
</body>
</html>
