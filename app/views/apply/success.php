<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Submitted</title>
  <link rel="stylesheet" href="/public/css/style.css"> <!-- optional -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8fafc;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background: #2e7d32;
      color: #fff;
      width: 100%;
      padding: 20px 0;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
      position: relative;
    }
    header h1 {
      font-size: 24px;
      margin-bottom: 5px;
    }
    .user-menu {
      position: absolute;
      right: 25px;
      top: 20px;
    }
    .user-menu-toggle {
      background: transparent;
      color: #fff;
      border: 1px solid #fff;
      padding: 8px 15px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .user-menu-toggle:hover {
      background: #fff;
      color: #2e7d32;
    }
    .user-menu-toggle::after {
      content: '▼';
      font-size: 10px;
      transition: transform 0.3s ease;
    }
    .user-menu-toggle.active::after {
      transform: rotate(180deg);
    }
    .dropdown-menu {
      position: absolute;
      top: 100%;
      right: 0;
      margin-top: 8px;
      background: #fff;
      border-radius: 6px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      min-width: 180px;
      display: none;
      z-index: 1000;
      overflow: hidden;
    }
    .dropdown-menu.active {
      display: block;
    }
    .dropdown-menu a {
      display: block;
      padding: 12px 18px;
      color: #333;
      text-decoration: none;
      font-size: 14px;
      transition: background 0.2s ease;
      border-bottom: 1px solid #f0f0f0;
    }
    .dropdown-menu a:last-child {
      border-bottom: none;
    }
    .dropdown-menu a:hover {
      background: #f5f5f5;
      color: #2e7d32;
    }
    .dropdown-menu a.logout-item {
      color: #c62828;
    }
    .dropdown-menu a.logout-item:hover {
      background: #ffebee;
      color: #b71c1c;
    }
    .content {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 40px;
      text-align: center;
      max-width: 400px;
    }
    .card h1 {
      color: #16a34a;
      margin-bottom: 10px;
    }
    .card p {
      color: #374151;
      margin-bottom: 20px;
    }
    .card a {
      display: inline-block;
      padding: 10px 20px;
      border-radius: 8px;
      background-color: #2563eb;
      color: white;
      text-decoration: none;
    }
    .card a:hover {
      background-color: #1d4ed8;
    }
  </style>
</head>
<body>
  <header>
    <h1>Application Submitted</h1>
    <div class="user-menu">
      <button class="user-menu-toggle" onclick="toggleUserMenu()">
        <?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'User', ENT_QUOTES, 'UTF-8') ?>
      </button>
      <div class="dropdown-menu" id="userDropdown">
        <a href="/apply/form">Apply for Application</a>
        <a href="/applicant/my-applications">My Applications</a>
        <a href="/applicant/profile">Profile</a>
        <a href="/logout" class="logout-item">Logout</a>
      </div>
    </div>
  </header>
  <div class="content">
    <div class="card">
      <h1>🎉 Application Submitted!</h1>
      <p>Your scholarship application has been successfully submitted.</p>
      <a href="/applicant/dashboard">Go Back to Dashboard</a>
    </div>
  </div>
  <script>
    function toggleUserMenu() {
      const dropdown = document.getElementById('userDropdown');
      const toggle = document.querySelector('.user-menu-toggle');
      dropdown.classList.toggle('active');
      toggle.classList.toggle('active');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
      const userMenu = document.querySelector('.user-menu');
      const dropdown = document.getElementById('userDropdown');
      if (userMenu && !userMenu.contains(event.target)) {
        dropdown.classList.remove('active');
        document.querySelector('.user-menu-toggle').classList.remove('active');
      }
    });
  </script>
</body>
</html>
