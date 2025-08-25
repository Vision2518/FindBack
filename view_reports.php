<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'moderator'])) {
    die("Access denied.");
}

include 'db_connect.php';
$sql="SELECT*FROM lost_items";
$lost=mysqli_query($conn, $sql);
$sql1="SELECT *FROM found_items";
$found=mysqli_query($conn, $sql1)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View Reports - FindBack</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
      color: #181818;
    }
    aside {
      width: 220px;
      background: #232323;
      min-height: 100vh;
      float: left;
      padding-top: 30px;
      box-shadow: 2px 0 8px rgba(0,0,0,0.08);
    }
    aside h2 {
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
    }
    aside a {
      display: block;
      margin-bottom: 10px;
      text-decoration: none;
    }
    aside button {
      width: 90%;
      padding: 12px;
      margin: 0 auto 10px auto;
      display: block;
      border: none;
      border-radius: 6px;
      background: #444;
      color: #fff;
      font-size: 1em;
      cursor: pointer;
      transition: background 0.2s;
    }
    aside button:hover, aside button:focus {
      background: #1976d2;
      color: #fff;
    }
    main {
      margin-left: 240px;
      padding: 40px 30px;
    }
    h1 {
      color: #1976d2;
      margin-top: 0;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin-bottom: 30px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 8px #e0e0e0;
    }
    th, td {
      padding: 10px 14px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }
    th {
      background: #f4f4f4;
      color: #1976d2;
    }
    tr:last-child td {
      border-bottom: none;
    }
    .status-open { color: #1976d2; font-weight: bold; }
    .status-resolved { color: #388e3c; font-weight: bold; }
    .status-claimed { color: #fbc02d; font-weight: bold; }
    .status-closed { color: #e74c3c; font-weight: bold; }
    /* Dark mode styles */
    body.dark-mode {
      background: #181818 !important;
      color: #f4f4f4 !important;
    }
    body.dark-mode aside {
      background: #111 !important;
      color: #f4f4f4 !important;
      box-shadow: 2px 0 8px rgba(0,0,0,0.2);
    }
    body.dark-mode aside h2 {
      color: #fff !important;
    }
    body.dark-mode aside button {
      background: #232323 !important;
      color: #fff !important;
    }
    body.dark-mode aside button:hover, body.dark-mode aside button:focus {
      background: #1976d2 !important;
      color: #fff !important;
    }
    body.dark-mode main {
      background: #181818 !important;
      color: #f4f4f4 !important;
    }
    body.dark-mode table {
      background: #232323 !important;
      color: #f4f4f4 !important;
      box-shadow: 0 0 8px #111;
    }
    body.dark-mode th {
      background: #232323 !important;
      color: #90caf9 !important;
    }
    body.dark-mode td {
      border-bottom: 1px solid #333 !important;
    }
    body.dark-mode .status-open { color: #90caf9 !important; }
    body.dark-mode .status-resolved { color: #66bb6a !important; }
    body.dark-mode .status-claimed { color: #ffe082 !important; }
    body.dark-mode .status-closed { color: #ef5350 !important; }
  </style>
</head>
<body>
  <div class="dark-toggle-container" style="position: fixed; top: 10px; right: 20px; z-index: 2000;">
    <?php include 'dark_mode_toggle.php'; ?>
  </div>
  <aside>
    <h2>🔧 Admin Panel</h2>
    <a href="admin_panel.php">
      <button>🏠 Dashboard</button>
    </a>
    <a href="manage_users.php">
      <button>👥 Manage Users</button>
    </a>
    <a href="view_reports.php">
      <button>📑 View Reports</button>
    </a>
    <a href="reward_system.php">
      <button>🎁 Reward System</button>
    </a>
    <a href="role_management.php">
      <button>🛡️ Role Management</button>
    </a>
    <a href="logout.php">
      <button style="background-color: #f44336; color: white;">🚪 Logout</button>
    </a>
  </aside>
  <main>
    <h1>Lost Item Reports</h1>
    <?php
   if(mysqli_num_rows($lost)>0)
   {
    echo "<table><tr><th>ID</th><th>Item Name</th><th>Description</th><th>Date Lost</th><th>Report Time</th><th>Status</th></tr>";
    while($row=mysqli_fetch_assoc ($lost))
    {
      $status = htmlspecialchars($row['status'] ?? 'Open');
      $status_class = 'status-' . strtolower($status);
      echo "<tr>
        <td>".$row['id']."</td>
        <td>".$row['item_name']."</td>
        <td>".$row['description']."</td>
        <td>".$row['date_lost']."</td>
        <td>".$row['created_at']."</td>
        <td>
          <form method='post' action='update_status.php' style='margin:0;'>
            <input type='hidden' name='id' value='".$row['id']."'>
            <input type='hidden' name='type' value='lost'>
            <select name='status' onchange='this.form.submit()'>
              ";
              $statuses = ['Open', 'Resolved', 'Claimed', 'Closed'];
              foreach ($statuses as $s) {
                $selected = ($row['status'] == $s) ? 'selected' : '';
                echo "<option value=\"$s\" $selected>$s</option>";
              }
      echo "  </select>
          </form>
        </td>
      </tr>";
    }
    echo "</table>";
   }
   else{
    echo "<p>No lost items found</p>";
   }
    ?>
    <br><br>
    <h1>Found Item Reports</h1>
    <?php
    if(mysqli_num_rows($found)>0)
    {
      echo "<table><tr><th>ID</th><th>Item Name</th><th>Description</th><th>Date Found</th><th>Found Location</th><th>Reported Time</th><th>Status</th></tr>";
      while($row=mysqli_fetch_assoc($found))
      {
        $status = htmlspecialchars($row['status'] ?? 'Open');
        $status_class = 'status-' . strtolower($status);
        echo "<tr>
          <td>".$row['id']."</td>
          <td>".$row['item_name']."</td>
          <td>".$row['description']."</td>
          <td>".$row['date_found']."</td>
          <td>".$row['location']."</td>
          <td>".$row['created_at']."</td>
          <td>
            <form method='post' action='update_status.php' style='margin:0;'>
              <input type='hidden' name='id' value='".$row['id']."'>
              <input type='hidden' name='type' value='found'>
              <select name='status' onchange='this.form.submit()'>
                ";
                $statuses = ['Open', 'Resolved', 'Claimed', 'Closed'];
                foreach ($statuses as $s) {
                  $selected = ($row['status'] == $s) ? 'selected' : '';
                  echo "<option value=\"$s\" $selected>$s</option>";
                }
        echo "  </select>
            </form>
          </td>
        </tr>";
      }
      echo "</table>";
    }
    else
    {
      echo"<p>No found items available</p>";
    }
    ?>
  </main>
</body>
</html>