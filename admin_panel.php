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
    <title>Admin Dashboard - FindBack</title>
    <link rel="stylesheet" href="dark.css" />
    <style>
      body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: #121212;
        color: white;
      }
      aside {
        width: 220px;
        background: #232323;
        min-height: 100vh;
        float: left;
        padding-top: 30px;
        box-shadow: 2px 0 8px rgba(0,0,0,0.08);
      }
      aside a, aside button {
        display: block;
        color: #ccc;
        padding: 16px 24px;
        text-decoration: none;
        font-size: 1.1em;
        border: none;
        background: none;
        text-align: left;
        width: 100%;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
      }
      aside a.active, aside a:hover, aside button:hover {
        background: #00bcd4;
        color: #181818;
      }
      main {
        margin-left: 220px;
        padding: 40px 30px;
      }
      header h1 {
        margin-top: 0;
        color: #00bcd4;
      }
      section p {
        font-size: 1.1em;
        margin-bottom: 18px;
      }
      /* --- DARK MODE --- */
      body.dark-mode {
        background: #f4f4f4 !important;
        color: #181818 !important;
      }
      body.dark-mode aside {
        background: #fff !important;
        color: #181818 !important;
        box-shadow: 2px 0 8px rgba(0,0,0,0.04);
      }
      body.dark-mode aside a, body.dark-mode aside button {
        color: #181818 !important;
        background: none !important;
      }
      body.dark-mode aside a.active, body.dark-mode aside a:hover, body.dark-mode aside button:hover {
        background: #1976d2 !important;
        color: #fff !important;
      }
      body.dark-mode main {
        background: #f4f4f4 !important;
        color: #181818 !important;
      }
      body.dark-mode header h1 {
        color: #1976d2 !important;
      }
    </style>
</head>
<body>
  <div style="position: fixed; top: 50px; right: 20px; z-index: 1000;">
    <?php include 'dark_mode_toggle.php'; ?>
  </div>
  <aside>
      <a href="admin_panel.php" class="active">Dashboard</a>
      <a href="view_reports.php">View Reports</a>
      <a href="manage_users.php"><button>👥 Manage Users</button></a>
      <a href="reward_system.php">Reward System</a>
      <a href="logout.php">Logout</a>
  </aside>
  <main>
      <header>
          <h1>Welcome Back, Admin!</h1>
      </header>
      <section>
          <p>Thank you for managing the FindBack system. Your work helps reconnect people with their lost belongings.</p>
          <p>Use the navigation on the left to review reports, manage users and administer rewards.</p>
          <p><em>Have a productive day!</em></p>
      </section>
  </main> 
</body>
</html>