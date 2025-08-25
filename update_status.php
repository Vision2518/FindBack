<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'moderator'])) {
    die("Access denied.");
}
include 'db_connect.php';

$id = intval($_POST['id']);
$type = ($_POST['type'] === 'found') ? 'found_items' : 'lost_items';
$status = mysqli_real_escape_string($conn, $_POST['status']);

mysqli_query($conn, "UPDATE $type SET status='$status' WHERE id=$id");

header("Location: admin_panel.php");
exit();
?>