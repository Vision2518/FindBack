<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
    $username = htmlspecialchars($_SESSION['user_name']);
    echo '
    <div style="position: fixed; top: 10px; right: 20px; font-family: Arial, sans-serif;">
        <a href="user_dashboard.php" style="text-decoration: none; color: #333; display: flex; align-items: center; font-weight: 600;">
            <span style="font-size: 20px; margin-right: 6px;">👤</span>
            <span>Hey, ' . $username . '</span>
        </a>
    </div>
    ';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="FindBack is a smart lost and found system that helps users report and retrieve lost items easily and securely." />
  <meta name="theme-color" content="#000000" />
  <title>FindBack - Smart Lost and Found System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
  body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #121212;
  color: white;
}



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

    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      font-size: 1em;
      transition: 0.3s ease;
    }

    nav a:hover,
    nav a.active {
      text-decoration: none;
        color: #00bcd4;

    }

    .digital-board {
      background: #000;
      margin: 30px auto;
      padding: 40px 10px;
      max-width: 650px;
      height: 130px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
     box-shadow: 0 0 20px rgba(0, 188, 212, 0.3);
    }

    .digital-text {
      position: absolute;
      opacity: 0;
      font-size: 1.4em;
      font-weight: bold;
      color: red;
      transition: opacity 0.8s ease-in-out;
    }

    @keyframes bounceInSlow {
      0%   { transform: scale(0.5); opacity: 0; }
      50%  { transform: scale(1.2); opacity: 1; }
      70%  { transform: scale(0.9); }
      100% { transform: scale(1); opacity: 1; }
    }

    @keyframes slideIn {
      0% { transform: translateX(100%); opacity: 0; }
      100% { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; }
    }

    .btn-container {
      text-align: center;
      margin-top: 30px;
    }
    .btn {
  background-color: #00bcd4;
  color: black;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 8px;
  border: none;
  margin: 10px;
  font-size: 1em;
  text-decoration: none;
  transition: background-color 0.3s ease;
  display: inline-block;
}

.btn:hover {
  background-color: #0097a7;
  transform: scale(1.05);
}


    .features {
      text-align: center;
      margin-top: 50px;
    }

    .features h2 {
      font-size: 2em;
      margin-bottom: 20px;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      max-width: 900px;
      margin: 0 auto;
      padding: 0 20px;
    }
     
     @media (max-width: 768px) {
    .features-grid {
      grid-template-columns: repeat(2, 1fr); /* Tablet = 2 per row */
    }
    }

     @media (max-width: 480px) {
    .features-grid {
     grid-template-columns: 1fr; /* Mobile = 1 per row */
    }
    }

    .features-grid div i {
      font-size: 1.8em;
      margin-bottom: 10px;
      color: white;
    }

    .features-grid div {
      background: rgba(255,255,255,0.1);
      padding: 20px;
      border-radius: 10px;
      font-weight: bold;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .features-grid div.show {
      opacity: 1;
      transform: translateY(0);
    }

    footer {
      background: #000;
      text-align: center;
      padding: 20px 0;
      font-size: 0.9em;
      color: #ccc;
      margin-top: 50px;
    }
   
    @keyframes pulseText {
  0% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.08); opacity: 0.85; }
  100% { transform: scale(1); opacity: 1; }
}

.btn span {
  display: inline-block;
  animation: pulseText 1.8s ease-in-out infinite;
}

  </style>
</head>
<body>

  <header>
    <h1> <i class="fas fa-search" style="color: white; margin-right: 10px;"></i> FindBack</h1>
    <h2>Smart Lost and Found System</h2>
    <p class="tagline">A smarter way to find your lost things.</p>
  </header>

  <nav aria-label="Main Navigation">
    <a href="homepage.html" class="active">Home</a>
    <a href="lost_report.html">Report Lost</a>
    <a href="found_report.html">Report Found</a>
    <a href="contact.html">Search</a>
    <a href="contact.html">Contact</a>
    <a href="register_form.php">Register</a>
    <a href="login.php">Login</a>
    <a href="admin_login.html">Admin</a>
  </nav>

  <div class="digital-board">
    <div class="digital-text" id="text1" aria-live="polite">Lost item?</div>
    <div class="digital-text" id="text2" aria-live="polite">Report your lost items now.</div>
    <div class="digital-text" id="text3" aria-live="polite">Found item?</div>
    <div class="digital-text" id="text4" aria-live="polite">Submit a found item and help others.</div>
  </div>

  <div class="btn-container">
    <a href="lost_report.html" class="btn"><span>Report Lost</span></a>
    <a href="found_report.html" class="btn"><span>Report Found</span></a>
 </div>


  <section class="features">
    <h2>Why FindBack?</h2>
    <div class="features-grid">
      <div><i class="fas fa-key"></i><br>OTP Verification</div>
      <div><i class="fas fa-bell"></i><br>Real-Time Notifications</div>
      <div><i class="fas fa-lock"></i><br>Secure Claims</div>
      <div><i class="fas fa-search"></i><br>Smart Search</div>
      <div><i class="fas fa-exclamation-circle"></i><br>Review Alerts</div>
      <div><i class="fas fa-lightbulb"></i><br>Item Match Suggestions</div>
      <div><i class="fas fa-user-secret"></i><br>Anonymous Reporting</div>
      <div><i class="fas fa-id-card"></i><br>Verified Ownership Proof</div>
    </div>
  </section>

  <footer>
    &copy; 2025 FindBack | Powered by Prem &amp; Vision
  </footer>

  <script>
  
    const animations = [
      { id: 'text1', animation: 'bounceInSlow', duration: 2000, nextDelay: 2500 },
      { id: 'text2', animation: 'slideIn', duration: 2000, nextDelay: 2500 },
      { id: 'text3', animation: 'bounceInSlow', duration: 2000, nextDelay: 2500 },
      { id: 'text4', animation: 'slideIn', duration: 2000, nextDelay: 2500 }
    ];

    let current = 0;

    function resetAll() {
      animations.forEach(item => {
        const el = document.getElementById(item.id);
        el.style.opacity = 0;
        el.style.animation = 'none';
        el.offsetHeight;
      });
    }

    function showNext() {
      resetAll();
      const item = animations[current];
      const el = document.getElementById(item.id);
      el.style.animation = `${item.animation} ${item.duration}ms ease forwards`;

      setTimeout(() => {
        el.style.animation = `fadeOut 1000ms ease forwards`;
      }, item.duration + 1000);

      current = (current + 1) % animations.length;
      setTimeout(showNext, item.duration + 1000 + item.nextDelay);
    }

    showNext();

    
    const fCards = document.querySelectorAll('.features-grid div');
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
        }
      });
    }, { threshold: 0.1 });

    fCards.forEach(card => observer.observe(card));
  </script>
</body>
</html>
