<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - FindBack</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #121212;
      color: white;
    }
    .hero {
      text-align: center;
      padding: 60px 20px 40px;
      animation: fadeIn 1.2s ease-in-out;
    }
    .hero h1 {
      font-size: 3em;
      margin-bottom: 10px;
    }
    .hero p {
      font-size: 1.2em;
      color: #ccc;
    }
    .contact-container {
      max-width: 600px;
      margin: 40px auto;
      padding: 30px;
      background-color: #1e1e1e;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 188, 212, 0.2);
      animation: slideUp 1.2s ease-in-out;
    }
    .contact-container h2 {
      text-align: center;
      margin-bottom: 25px;
    }
    form label {
      display: block;
      margin: 15px 0 5px;
      font-weight: bold;
    }
    form input, form textarea {
      width: 100%;
      padding: 10px;
      background: #2c2c2c;
      border: none;
      color: white;
      border-radius: 5px;
    }
    form input:focus, form textarea:focus {
      outline: none;
      background: #333;
    }
    form button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background-color: #00bcd4;
      border: none;
      color: black;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    form button:hover {
      background-color: #0097a7;
    }
    footer {
      text-align: center;
      padding: 25px;
      background-color: #1f1f1f;
      margin-top: 50px;
      color: #888;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }
    /* --- DARK MODE --- */
    body.dark-mode {
      background: #f4f4f4 !important;
      color: #181818 !important;
    }
    body.dark-mode .hero {
      background: #e0e0e0 !important;
      color: #181818 !important;
    }
    body.dark-mode .contact-container {
      background-color: #fff !important;
      color: #181818 !important;
      box-shadow: 0 0 15px rgba(0,0,0,0.08);
    }
    body.dark-mode form input,
    body.dark-mode form textarea {
      background: #f4f4f4 !important;
      color: #181818 !important;
    }
    body.dark-mode form input:focus,
    body.dark-mode form textarea:focus {
      background: #e0e0e0 !important;
    }
    body.dark-mode form button {
      background-color: #1976d2 !important;
      color: #fff !important;
    }
    body.dark-mode form button:hover {
      background-color: #1565c0 !important;
    }
    body.dark-mode footer {
      background-color: #e0e0e0 !important;
      color: #333 !important;
    }
  </style>
</head>
<body>
  <?php
    // User greeting box (fixed top right)
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
        $username = htmlspecialchars($_SESSION['user_name']);
        echo '
        <div style="position: fixed; top: 10px; right: 20px; font-family: Arial, sans-serif; z-index: 1001;">
            <a href="user_dashboard.php" style="text-decoration: none; color: #333; display: flex; align-items: center; font-weight: 600;">
                <span style="font-size: 20px; margin-right: 6px;">👤</span>
                <span>Hey, ' . $username . '</span>
            </a>
        </div>
        ';
    }
  ?>
  <div style="position: fixed; top: 50px; right: 20px; z-index: 1000;">
    <?php include 'dark_mode_toggle.php'; ?>
  </div>

  <div class="hero">
    <h1>Contact Us</h1>
    <p>If you have any questions, issues, or suggestions, we’d love to hear from you.</p>
  </div>

  <div class="contact-container">
    <h2>Send us a message</h2>
    <form>
      <label for="name">Your Name</label>
      <input type="text" id="name" name="name" placeholder="Enter your name" required />

      <label for="email">Your Email</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required />

      <label for="message">Message</label>
      <textarea id="message" name="message" placeholder="Write your message here..." rows="6" required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </div>
  <footer>
    &copy; 2025 FindBack. All rights reserved.
  </footer>
</body>
</html>
