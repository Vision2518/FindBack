<!DOCTYPE html>
<html lang="en">
<head>
<style>
        header {
      background:#000 ;
      color: #fff;
      text-align: center;
      padding: 40px 20px 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    header h1 {
      margin: 0;
      font-size: 2.8em;
    }

    header h2 {
      margin: 10px 0;
      font-weight: bold;
      font-size: 1.5em;
      color: #fff;
    }

    header p.tagline {
      margin: 4px 0 0;
      font-size:0.9em;
      color: #fff;
      font-weight: bold;
    }

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
body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #404147, #2b2c2e);
      color: #fff;
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

</style>   
</head>
<body>
  <header>
    <h1>🔍 FindBack</h1>
    <h2>Smart Lost and Found System</h2>
    <p class="tagline">A smarter way to find your lost things.</p>
  </header>

  <nav aria-label="Main Navigation">
    <a href="homepage.html" class="active">Home</a>
    <a href="lost_report.html">Report Lost</a>
    <a href="found_report.html">Report Found</a>
    <a href="register.html">Register</a>
    <a href="#">Search</a>
    <a href="#">Contact Us</a>
    <a href="admin_login.html">Admin</a>
  </nav>
  
</body>
</html>
 