<?php
session_start();
include 'db_connect.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$username' OR name = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['Password'])) {
            if ($row['role'] === 'admin') {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['role'] = 'admin';

                header("Location: admin_panel.php");
                exit();
            } else {
                echo "Access denied. You are not an admin.";
            }
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Admin account not found.";
    }
} else {
    header("Location: admin_login.html");
    exit();
}
?>
