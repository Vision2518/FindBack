<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: homepage.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user info
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Handle profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        $filename = basename($_FILES["profile_pic"]["name"]);
        $target_file = $target_dir . time() . "_" . $filename;
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);
        $profile_pic_sql = ", profile_pic='" . mysqli_real_escape_string($conn, $target_file) . "'";
    } else {
        $profile_pic_sql = "";
    }

    $update = mysqli_query($conn, "UPDATE users SET name='$name', email='$email', phone='$phone' $profile_pic_sql WHERE id='$user_id'");
    if ($update) {
        header("Location: user_dashboard.php?msg=Profile+updated");
        exit();
    } else {
        $error = "Update failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 400px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        label { display: block; margin-top: 15px; }
        input[type="text"], input[type="email"], input[type="file"] { width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc; }
        button { margin-top: 20px; padding: 10px 20px; background: #1976d2; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        .profile-pic { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 2px solid #00bcd4; }
        .error { color: #e74c3c; margin-top: 10px; }
        .success { color: #388e3c; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <?php if (!empty($user['profile_pic'])): ?>
            <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" class="profile-pic" alt="Profile Picture">
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            <label>Profile Picture</label>
            <input type="file" name="profile_pic" accept="image/*">
            <button type="submit">Save Changes</button>
        </form>
        <?php if (isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
        <div style="margin-top:15px;">
            <a href="user_dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>