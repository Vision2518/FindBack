<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Declare Reward - FindBack</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #404147, #2b2c2e);
      color: #fff;
    }
    header {
      background:#000 ;
      color: #fff;
      text-align: center;
      padding: 40px 20px 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    header h1 { margin: 0; font-size: 2.8em; }
    header h2 { margin: 10px 0; font-weight: bold; font-size: 1.5em; color: #fff; }
    nav {
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 12px;
      margin: 20px auto;
      max-width: 90%;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
      padding: 15px 0;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      font-size: 1em;
      transition: 0.3s ease;
    }
    nav a:hover,
    nav a.active {
      text-decoration: underline;
      color: yellow;
    }
    .form-container {
      background: rgba(255,255,255,0.08);
      padding: 30px 20px;
      margin: 40px auto;
      border-radius: 10px;
      max-width: 400px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    form label {
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
    }
    form input[type="number"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: none;
      margin-bottom: 20px;
      font-size: 1em;
    }
    button[type="submit"] {
      background: rgba(255,255,255,0.1);
      color: #fff;
      font-weight: bold;
      padding: 12px 30px;
      border-radius: 8px;
      border: none;
      font-size: 1em;
      cursor: pointer;
      transition: 0.3s ease;
    }
    button[type="submit"]:hover {
      background: #111;
      transform: scale(1.05);
    }
    .message {
      text-align: center;
      font-size: 1.1em;
      margin-top: 30px;
      background: rgba(0,0,0,0.3);
      border-radius: 8px;
      padding: 18px;
    }
    a.btn-home {
      display: inline-block;
      margin-top: 20px;
      background: rgba(255,255,255,0.1);
      color: #fff;
      font-weight: bold;
      padding: 10px 24px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
    }
    a.btn-home:hover { background: #111; }
    footer {
      background: #000;
      text-align: center;
      padding: 20px 0;
      font-size: 0.9em;
      color: #ccc;
      margin-top: 50px;
    }
  </style>
</head>
<body>
  <header>
    <h1>🔍 FindBack</h1>
    <h2>Declare a Reward</h2>
  </header>
  <nav aria-label="Main Navigation">
    <a href="homepage.html">Home</a>
    <a href="lost_report.html">Report Lost</a>
    <a href="found_report.html">Report Found</a>
    <a href="#">Search</a>
    <a href="#">Contact Us</a>
    <a href="admin_login.html">Admin</a>
  </nav>
  <div class="form-container">
<?php
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $item_id=intval($_POST['item_id']);
    $reward=floatval($_POST['reward']);
    if($reward>=0)
    {
        $sql="UPDATE lost_items SET reward_amount=$reward WHERE id=$item_id";
        if($conn->query($sql)===TRUE)
        {
            echo "<div class='message'>✅ Reward of Rs. $reward saved successfully!</div>";
        } else {
            echo "<div class='message'>❌ Error saving reward: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='message'>Invalid input!</div>";
    }
    echo "<a class='btn-home' href='homepage.html'>Go Home</a>";
    exit();
}
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $item_id = intval($_GET['id']);
?>
    <form method="POST">
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <label>Declare Reward (Optional):</label>
        <input type="number" name="reward" step="10" min="0" placeholder="Enter reward amount">
        <button type="submit">Set Reward</button>
    </form>
<?php
} else {
    echo "<div class='message'><p>Invalid request. No item ID provided.</p></div>";
    echo "<a class='btn-home' href='homepage.html'>Go Home</a>";
}
?>
  </div>
  <footer>
    &copy; 2025 FindBack | Powered by Prem &amp; Vision
  </footer>
</body>
</html>