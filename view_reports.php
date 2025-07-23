<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header("Location: admin_login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Panel - FindBack</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      color: #333;
      display: flex;
      height: 100vh;
    }

    aside {
      width: 220px;
      background: #222;
      color: #fff;
      padding: 20px;
    }

    aside h1 {
      font-size: 1.5em;
      margin: 0 0 20px 0;
    }

    aside nav {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    aside nav a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
    }

    aside nav a:hover {
      text-decoration: underline;
    }

    main {
      flex-grow: 1;
      padding: 30px;
      overflow-y: auto;
    }

    main h2 {
      border-bottom: 2px solid #333;
      padding-bottom: 5px;
      margin-top: 40px;
    }

    .report {
      background: #fff;
      border: 1px solid #ddd;
      padding: 15px;
      margin: 15px 0;
      border-radius: 5px;
      box-shadow: 1px 1px 5px rgba(0,0,0,0.05);
      white-space: pre-line;
    }

    .no-reports {
      color: #888;
      font-style: italic;
    }
  </style>
</head>
<body>

  <aside>
    <h1>🔒 Admin</h1>
    <nav>
      <a href="view_reports.php">View Reports</a>
      <a href="logout.php">Log Out</a>
    </nav>
  </aside>

  <main>
    <h2>Lost Reports</h2>
    <?php
    $file = fopen("lost_items.txt", "r");
    if ($file) {
      $found = false;
      while (($line = fgets($file)) !== false) {
        $found = true;
        echo '<div class="report">' . htmlspecialchars($line) . '</div>';
      }
      fclose($file);
      if (!$found) {
        echo '<p class="no-reports">No lost reports found.</p>';
      }
    } else {
      echo '<p class="no-reports">No lost reports found.</p>';
    }
    ?>

    <h2>Found Reports</h2>
    <?php
    $file = fopen("found_items.txt", "r");
    if ($file) {
      $found = false;
      while (($line = fgets($file)) !== false) {
        $found = true;
        echo '<div class="report">' . htmlspecialchars($line) . '</div>';
      }
      fclose($file);
      if (!$found) {
        echo '<p class="no-reports">No found reports found.</p>';
      }
    } else {
      echo '<p class="no-reports">No found reports found.</p>';
    }
    ?>
  </main>

</body>
</html>