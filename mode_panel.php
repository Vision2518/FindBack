<?php
session_start();
if ($_SESSION['role'] !== 'moderator') {
    die("Access denied. Moderators only.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Moderator Panel</title>
</head>
<body>
    <h1>Welcome, Moderator</h1>
    <ul>
        <li><a href="view_reports.php">View Reports</a></li>
        <li><a href="report_actions.php">Manage Lost/Found Items</a></li>
    </ul>
</body>
</html>
