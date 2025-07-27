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
    <link rel="stylesheet" href="test.css" />
</head>
<body>

   <aside>
        <a href="admin_panel.php" class="active">Dashboard</a>
        <a href="view_reports.php">View Reports</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="reward_system.php">Reward System</a>
        <a href="logout.php">Logout</a>
</aside>
  <main>
    <h1>Lost Item Reports</h1>
    <?php
   if(mysqli_num_rows($lost)>0)
   {
    echo "<table border='1'><tr><th>ID</th><th>Item Name</th><th>Description</th><th>Date Lost</th><th>Report Time</th></tr>";
    while($row=mysqli_fetch_assoc ($lost))
    {
      echo "<tr><td>".$row['id']."</td><td>".$row['item_name']."</td><td>".$row['description']."</td><td>".$row['date_lost']."</td><td>".$row['created_at']."</td></tr>";
    }echo "</table>";
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
      echo "<table border='1'><tr><th>ID</th><th>Item Name</th><th>Description</th><th>Date Found</th><th>Found Location</th><th>Reported Time</th>";
      while($row=mysqli_fetch_assoc($found))
      {
        echo "<tr><td>".$row['id']."</td><td>".$row['item_name']."</td><td>".$row['description']."</td><td>".$row['date_found']."</td><td>".$row['location']."</td><td>".$row['created_at']."</td></tr>";
      }echo "</table>";
    }
    else
    {
      echo"<p>No found items available</p>";
    }
    ?>

   
  </main>

</body>
</html>