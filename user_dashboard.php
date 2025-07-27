<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: homepage.html");
    exit();
}

include 'db_connect.php';

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch user info by ID
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);

// Fetch lost items reported by this user
$lost_items = mysqli_query($conn, "SELECT * FROM lost_items WHERE reporter_name='" . mysqli_real_escape_string($conn, $user_name) . "'");

// Fetch found items reported by this user
$found_items = mysqli_query($conn, "SELECT * FROM found_items WHERE  reporter_name='" . mysqli_real_escape_string($conn, $user_name) . "'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
    }
    .container {
      max-width: 800px;
      margin: auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      margin-top: 40px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h1, h2 {
      color: #333;
    }

    ul {
      list-style: square;
      padding-left: 20px;
    }

    .btn {
      display: inline-block;
      padding: 10px 15px;
      margin: 10px 5px 0 0;
      background: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 6px;
    }

    .btn-danger {
      background: #e74c3c;
    }

    .badge {
      padding: 5px 10px;
      border-radius: 8px;
      font-weight: bold;
    }

    .badge.admin {
      background: red;
      color: white;
    }

    .badge.moderator {
      background: green;
      color: white;
    }

    .badge.user {
      background: blue;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <p>Your role: <span class="badge <?php echo $user['role']; ?>"><?php echo ucfirst($user['role']); ?></span></p>

    <h2>Your Lost Item Reports</h2>
    <?php if (mysqli_num_rows($lost_items) > 0): ?>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($lost_items)) : ?>
          <li><?php echo htmlspecialchars($row['item_name']); ?> - <?php echo htmlspecialchars($row['location']); ?></li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>No lost items reported yet.</p>
    <?php endif; ?>

    <h2>Your Found Item Reports</h2>
    <?php if (mysqli_num_rows($found_items) > 0): ?>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($found_items)) : ?>
          <li><?php echo htmlspecialchars($row['item_name']); ?> - <?php echo htmlspecialchars($row['location']); ?></li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>No found items reported yet.</p>
    <?php endif; ?>

    <a href="lost_report.html" class="btn">Report Lost Item</a>
    <a href="found_report.html" class="btn">Report Found Item</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</body>
</html>
