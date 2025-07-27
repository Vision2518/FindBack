<?php
session_start();
if(!isset($_SESSION['loggedin']))
{
    header("location:admin_login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard -FindBack</title>
    <link rel="stylesheet" href="test.css" />
</head>
<body>
    <aside>
        <a href="admin_panel.php" class="active">Dashboard</a>
        <a href="view_reports.php">View Reports</a>
        <a href="manage_users.php"><button>👥 Manage Users</button></a>
        <a href="reward_system.php">Reward System</a>
        <a href="logout.php">Logout</a>
</aside>
<main>
    <header>
        <H1>Welcome Back,Admin!</H1>
</header>
<section>
    <p>Thank you for managing the FindBack system. Your work helps reconnect people with their lost belongings.</P>
    <p>Use the navigation on the left to review reports,manage users and administer rewards.</p>
    <p><em>Have a productive day!</em></p>
</section>
</main> 
</body>
</html>