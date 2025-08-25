<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: homepage.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Fetch current password hash
    $result = mysqli_query($conn, "SELECT password FROM users WHERE id='$user_id'");
    $row = mysqli_fetch_assoc($result);

    if (!$row || !password_verify($current, $row['password'])) {
        $error = "Current password is incorrect.";
    } elseif ($new !== $confirm) {
        $error = "New passwords do not match.";
    } elseif (strlen($new) < 6) {
        $error = "New password must be at least 6 characters.";
    } else {
        $new_hash = password_hash($new, PASSWORD_DEFAULT);
        $update = mysqli_query($conn, "UPDATE users SET password='$new_hash' WHERE id='$user_id'");
        if ($update) {
            $success = "Password changed successfully!";
        } else {
            $error = "Failed to update password. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 400px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        label { display: block; margin-top: 15px; }
        input[type="password"] { width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc; }
        button { margin-top: 20px; padding: 10px 20px; background: #1976d2; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        .error { color: #e74c3c; margin-top: 10px; }
        .success { color: #388e3c; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <?php if ($error) echo '<div class="error">'.$error.'</div>'; ?>
        <?php if ($success) echo '<div class="success">'.$success.'</div>'; ?>
        <form method="post">
            <label>Current Password</label>
            <input type="password" name="current_password" required>
            <label>New Password</label>
            <input type="password" name="new_password" required>
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" required>
            <button type="submit">Change Password</button>
        </form>
        <div style="margin-top:15px;">
            <a href="user_dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>