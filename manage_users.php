<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
  header("Location: admin_login.html");
  exit();
}

// Handle role change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role_change_id'], $_POST['new_role'])) {
    $userId = (int)$_POST['role_change_id'];
    $newRole = $_POST['new_role'];
    $allowedRoles = ['admin', 'moderator', 'user'];
    if (in_array($newRole, $allowedRoles)) {
        $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $newRole, $userId);
        $stmt->execute();
    }
}

// Filters
$search = $_GET['search'] ?? '';
$month = $_GET['month'] ?? '';
$sort = $_GET['sort'] ?? 'latest';
$conditions = [];

if (!empty($search)) {
    $safe_search = $conn->real_escape_string($search);
    $conditions[] = "(name LIKE '%$safe_search%' OR email LIKE '%$safe_search%' OR phone LIKE '%$safe_search%')";
}
if (!empty($month)) {
    $safe_month = (int)$month;
    $conditions[] = "MONTH(created_at) = $safe_month";
}
$where = '';
if (!empty($conditions)) {
    $where = "WHERE " . implode(' AND ', $conditions);
}
$order = ($sort === 'oldest') ? 'ASC' : 'DESC';
$sql = "SELECT * FROM users $where ORDER BY created_at $order";
$result = $conn->query($sql);

function highlightSearch($text, $search) {
    if (!$search) return htmlspecialchars($text);
    $escapedSearch = preg_quote($search, '/');
    return preg_replace("/($escapedSearch)/i", '<span style="background-color:yellow;font-weight:bold;">$1</span>', htmlspecialchars($text));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Users</title>
  <link rel="stylesheet" href="test.css" />
  <style>
    /* Table styling */
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 8px; text-align: center; border: 1px solid #ccc; }
   th {
  background-color: #f2f2f2; /* Light gray */
  color: #333;               /* Dark text */
  padding: 8px;
  text-align: center;
  border: 1px solid #ccc;
}

    /* Role badges */
    .role-badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 12px;
      font-weight: bold;
      color: white;
      font-size: 0.9em;
      min-width: 70px;
      text-transform: capitalize;
    }
    .admin {
      background-color: #d32f2f; /* strong red */
    }
    .moderator {
      background-color: #388e3c; /* strong green */
    }
    .user {
      background-color: #1976d2; /* blue */
    }

    /* Form inline style */
    form.inline {
      display: inline-block;
      margin-top: 5px;
    }

    /* Select and button styling */
    select {
      padding: 5px 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 0.9em;
      cursor: pointer;
    }

    button {
      padding: 6px 12px;
      border-radius: 4px;
      border: none;
      background-color: #1976d2;
      color: white;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #1565c0;
    }

    /* Sidebar */
    aside {
  width: 180px;
  height: 100vh;
  background-color: #222; /* dark background */
  padding: 20px;
  position: fixed;
  color: #fff; /* default text color white */
  font-family: Arial, sans-serif;
}

aside h2 {
  margin-bottom: 20px;
  font-size: 18px;
  color: #fff;
}

aside a {
  text-decoration: none;
  display: block;
  margin: 5px 0;
}

aside button {
  padding: 10px;
  border: none;
  background-color: #333; /* dark button bg */
  color: #fff; /* white text */
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  text-align: left;
  transition: background-color 0.3s ease;
  width: 100%;
  display: flex;
  align-items: center;
  gap: 10px;
}

aside button:hover {
  zbackground-color: #555; /* lighter on hover */
  color: #ffd700; /* optional gold highlight */
}

  </style>
</head>
<body>
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
    <h1>Manage Users</h1>

    <form method="GET">
      <input type="text" name="search" placeholder="Search by name, email, or phone" value="<?=htmlspecialchars($search)?>">
      <select name="month">
        <option value="">-- Filter by Month --</option>
        <?php for ($m = 1; $m <= 12; $m++): ?>
          <option value="<?=$m?>" <?=($month == $m) ? 'selected' : ''?>><?=date('F', mktime(0, 0, 0, $m, 1))?></option>
        <?php endfor; ?>
      </select>
      <select name="sort">
        <option value="">Sort by</option>
        <option value="latest" <?=($sort == 'latest') ? 'selected' : ''?>>Latest</option>
        <option value="oldest" <?=($sort == 'oldest') ? 'selected' : ''?>>Oldest</option>
      </select>
      <button type="submit">Search</button>
      <a href="manage_users.php">Reset</a>
    </form>

    <?php if($result->num_rows > 0): ?>
      <table>
        <tr>
          <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Registered At</th><th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?=$row['id']?></td>
            <td><?=highlightSearch($row['name'], $search)?></td>
            <td><?=highlightSearch($row['email'], $search)?></td>
            <td><?=highlightSearch($row['phone'], $search)?></td>
            <td><span class="role-badge <?=$row['role']?>"><?=htmlspecialchars(ucfirst($row['role']))?></span></td>
            <td><?=$row['created_at']?></td>
            <td>
              <a href="user_action.php?action=edit&id=<?=$row['id']?>">Edit</a> |
              <a href="user_action.php?action=delete&id=<?=$row['id']?>" onclick="return confirm('Are you sure?');">Delete</a><br>
              <form method="POST" class="inline">
                <input type="hidden" name="role_change_id" value="<?=$row['id']?>">
                <select name="new_role">
                  <option value="admin" <?=($row['role']=='admin')?'selected':''?>>Admin</option>
                  <option value="moderator" <?=($row['role']=='moderator')?'selected':''?>>Moderator</option>
                  <option value="user" <?=($row['role']=='user')?'selected':''?>>User</option>
                </select>
                <button type="submit">Change</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p style="text-align:center;">No users registered yet.</p>
    <?php endif; ?>
  </main>
</body>
</html>
