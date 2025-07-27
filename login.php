<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if ($user['role'] === 'admin') {
            $error = "Admins must log in from the admin login page.";
        } elseif (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            switch ($user['role']) {
                case 'moderator':
                    header('Location: moderator_panel.php');
                    break;
                case 'user':
                    header('Location: user_dashboard.php');
                    break;
                default:
                    header('Location: homepage.html');
            }
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        form {
            background: white;
            padding: 20px;
            width: 300px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }
        p.error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Login</h2>
<form method="POST" action="login.php">
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    
    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>

</body>
</html>
