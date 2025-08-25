<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: homepage.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? '';

if (!in_array($type, ['lost', 'found']) || !is_numeric($id)) {
    die("Invalid request.");
}

$table = ($type === 'lost') ? 'lost_items' : 'found_items';

// Ownership check
$query = "SELECT * FROM $table WHERE id=? AND reporter_name=(SELECT name FROM users WHERE id=?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("You are not authorized to delete this report.");
}

// Delete report
$delete = $conn->prepare("DELETE FROM $table WHERE id=?");
$delete->bind_param("i", $id);
$delete->execute();

header("Location: user_dashboard.php");
exit();
?>
