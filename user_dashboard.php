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

// Fetch lost items reported by this user (with status)
$lost_items = mysqli_query($conn, "SELECT * FROM lost_items WHERE reporter_name='" . mysqli_real_escape_string($conn, $user_name) . "'");

// Fetch found items reported by this user (with status)
$found_items = mysqli_query($conn, "SELECT * FROM found_items WHERE reporter_name='" . mysqli_real_escape_string($conn, $user_name) . "'");

// Example: Fetch recent activity (replace with your own logic)
$recent_activity = [
    "Lost item 'Wallet' reported on 2025-07-25",
    "Found item 'Keys' marked as resolved"
];

// Example: Notification (replace with your own logic)
$match_notification = null;
// $match_notification = "A found item matches your lost report!";

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
    .delete-link {
      color: #e74c3c;
      margin-left: 10px;
      text-decoration: none;
      font-size: 18px;
      vertical-align: middle;
    }
    .delete-link:hover {
      text-decoration: underline;
    }
    .profile-section {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 20px;
    }
    .profile-section img {
      width: 80px; height: 80px; border-radius: 50%; object-fit: cover;
      border: 2px solid #00bcd4;
    }
    .profile-section .info { flex: 1; }
    .profile-section .actions a {
      margin-right: 10px;
      text-decoration: underline;
      color: #1976d2;
      font-size: 0.95em;
    }
    .search-bar {
      margin-bottom: 20px;
    }
    .search-bar input {
      padding: 8px;
      width: 250px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .export-btn {
      float: right;
      margin-top: -40px;
      background: #1976d2;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
    }
    .notification {
      background: #fff3cd;
      color: #856404;
      padding: 10px 16px;
      border-radius: 6px;
      margin-bottom: 18px;
      border: 1px solid #ffeeba;
    }
    .recent-activity {
      background: #f9f9f9;
      border-radius: 8px;
      padding: 12px 18px;
      margin-bottom: 20px;
      font-size: 0.98em;
    }
    /* Dark mode styles */
    body.dark-mode {
      background: #181818 !important;
      color: #f4f4f4 !important;
    }
    body.dark-mode .container {
      background: #232323 !important;
      color: #f4f4f4 !important;
    }
    body.dark-mode .btn {
      background: #444 !important;
      color: #fff !important;
    }
    body.dark-mode .btn-danger {
      background: #c0392b !important;
    }
    body.dark-mode .badge.admin {
      background: #b71c1c !important;
    }
    body.dark-mode .badge.moderator {
      background: #1b5e20 !important;
    }
    body.dark-mode .badge.user {
      background: #0d47a1 !important;
    }
    body.dark-mode .delete-link {
      color: #ff7675 !important;
    }
    body.dark-mode .recent-activity {
      background: #232323 !important;
      color: #f4f4f4 !important;
    }
    body.dark-mode .notification {
      background: #333 !important;
      color: #ffe082 !important;
      border-color: #ffe082 !important;
    }
    body.dark-mode .profile-section img {
      border-color: #1976d2;
    }
  </style>
</head>
<body>
  <div class="dark-toggle-container" style="position: fixed; top: 10px; right: 20px; z-index: 2000;">
    <?php include 'dark_mode_toggle.php'; ?>
  </div>
  <div class="container">

    <!-- 1. Profile Section -->
    <div class="profile-section">
      <img src="<?php echo htmlspecialchars($user['profile_pic'] ?? 'default_avatar.png'); ?>" alt="Profile Picture">
      <div class="info">
        <strong><?php echo htmlspecialchars($user['name']); ?></strong><br>
        <?php echo htmlspecialchars($user['email']); ?><br>
        <?php echo htmlspecialchars($user['phone']); ?>
      </div>
      <div class="actions">
        <a href="edit_profile.php">Edit Profile</a>
        <a href="change_password.php">Change Password</a>
      </div>
    </div>

    <!-- 2. Search/Filter Reports -->
    <form class="search-bar" method="get" action="">
      <input type="text" name="search" placeholder="Search reports by item, date, location..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
      <button type="submit">Search</button>
    </form>

    <!-- 3. Notifications -->
    <?php if ($match_notification) : ?>
      <div class="notification">
        <?php echo htmlspecialchars($match_notification); ?>
      </div>
    <?php endif; ?>

    <!-- 4. Export Reports -->
    <form method="post" action="export_reports.php" style="display:inline;">
      <button type="submit" class="export-btn">Export as CSV</button>
    </form>

    <!-- 5. Recent Activity -->
    <div class="recent-activity">
      <strong>Recent Activity:</strong>
      <ul>
        <?php foreach ($recent_activity as $activity): ?>
          <li><?php echo htmlspecialchars($activity); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- 6. Lost Item Reports with Status -->
    <h2>Your Lost Item Reports</h2>
    <?php if (mysqli_num_rows($lost_items) > 0): ?>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($lost_items)) : ?>
          <li>
            <?php echo htmlspecialchars($row['item_name']); ?> - <?php echo htmlspecialchars($row['location']); ?>
            <span style="margin-left:10px; color: #1976d2;">
              [Status: <?php echo htmlspecialchars($row['status'] ?? 'Open'); ?>]
            </span>
            <a href="delete_report.php?type=lost&id=<?php echo $row['id']; ?>"
               class="delete-link"
               onclick="return confirm('Are you sure you want to delete this report?');"
               title="Delete this report">🗑️</a>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p style="color: #e74c3c;">No lost items reported yet.</p>
    <?php endif; ?>

    <!-- 7. Found Item Reports with Status -->
    <h2>Your Found Item Reports</h2>
    <?php if (mysqli_num_rows($found_items) > 0): ?>
      <ul>
        <?php while ($row = mysqli_fetch_assoc($found_items)) : ?>
          <li>
            <?php echo htmlspecialchars($row['item_name']); ?> - <?php echo htmlspecialchars($row['location']); ?>
            <span style="margin-left:10px; color: #1976d2;">
              [Status: <?php echo htmlspecialchars($row['status'] ?? 'Open'); ?>]
            </span>
            <a href="delete_report.php?type=found&id=<?php echo $row['id']; ?>"
               class="delete-link"
               onclick="return confirm('Are you sure you want to delete this report?');"
               title="Delete this report">🗑️</a>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
       <p style="color: #e74c3c;">No found items reported yet.</p>
    <?php endif; ?>

    <!-- 8. Contact Support -->
    <div style="margin-top:30px;">
      <a href="contact.php" class="btn">Contact Support</a>
    </div>

    <!-- 9. Admin/Moderator Tools (visible only for admins/mods) -->
    <?php if (in_array($user['role'], ['admin', 'moderator'])): ?>
      <div style="margin-top:30px; background:#e3f2fd; padding:16px; border-radius:8px;">
        <strong>Admin/Moderator Tools:</strong>
        <ul>
          <li><a href="manage_users.php">Manage Users</a></li>
          <li><a href="view_all_reports.php">View All Reports</a></li>
        </ul>
      </div>
    <?php endif; ?>

    <a href="lost_report.html" class="btn">Report Lost Item</a>
    <a href="found_report.html" class="btn">Report Found Item</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
    <footer style="margin-top:40px;">
      <p>&copy; 2023 FindBack. All rights reserved.</p>
    </footer>
  </div>
</body>
</html>
