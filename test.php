<?php
session_start();
$_SESSION['user_loggedin'] = true;
$_SESSION['name'] = 'Vision';

if (isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] === true) {
    $username = htmlspecialchars($_SESSION['name']);
    echo '
    <div style="position: fixed; top: 10px; right: 20px; font-family: Arial, sans-serif;">
        <a href="user_dashboard.php" style="text-decoration: none; color: #333; display: flex; align-items: center; font-weight: 600;">
            <span style="font-size: 20px; margin-right: 6px;">👤</span>
            <span>Hey, ' . $username . '</span>
        </a>
    </div>
    ';
}
?>
