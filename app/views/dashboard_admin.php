<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Naujan Scholarship System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Open Sans', Arial, sans-serif;
      background: linear-gradient(135deg, #e8f5e9, #fff3e0);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    header {
      background: #1b5e20;
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

    header p {
      font-size: 15px;
      opacity: 0.9;
    }

    .logout {
      position: absolute;
      right: 25px;
      top: 22px;
      background: transparent;
      color: #fff;
      border: 1px solid #fff;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .logout:hover {
      background: #fff;
      color: #1b5e20;
    }

    .container {
      background: #fff;
      margin-top: 40px;
      padding: 30px;
      width: 90%;
      max-width: 1000px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      color: #1b5e20;
      margin-bottom: 25px;
      font-size: 22px;
    }

    .cards {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: #f1f8e9;
      border-radius: 10px;
      padding: 25px;
      width: 220px;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    .card h3 {
      color: #33691e;
      font-size: 16px;
      margin-bottom: 8px;
    }

    .card span {
      font-size: 24px;
      font-weight: bold;
      color: #2e7d32;
    }

    .links {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
    }

    .link-btn {
      display: inline-block;
      padding: 12px 20px;
      background: linear-gradient(90deg, #43a047, #66bb6a);
      color: white;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .link-btn:hover {
      background: linear-gradient(90deg, #388e3c, #43a047);
      transform: translateY(-1px);
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    footer {
      text-align: center;
      padding: 20px;
      margin-top: 40px;
      color: #666;
      font-size: 14px;
    }

    @media (max-width: 600px) {
      .card { width: 100%; }
    }
  </style>
</head>

<body>

<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
  <header>
    <h1>Naujan Scholarship System</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'Administrator', ENT_QUOTES, 'UTF-8') ?></p>
    <a href="/logout" class="logout">Logout</a>
  </header>

  <div class="container">
    <h2>Admin Dashboard</h2>

    <!-- Summary cards -->
    <div class="cards">
      <div class="card">
        <h3>Total Applicants</h3>
        <span><?= isset($statistics) ? $statistics['total'] : 0 ?></span>
      </div>
      <div class="card">
        <h3>Pending Applications</h3>
        <span><?= isset($statistics) ? $statistics['pending'] : 0 ?></span>
      </div>
      <div class="card">
        <h3>Approved Scholarships</h3>
        <span><?= isset($statistics) ? $statistics['approved'] : 0 ?></span>
      </div>
      <div class="card">
        <h3>Rejected</h3>
        <span><?= isset($statistics) ? $statistics['rejected'] : 0 ?></span>
      </div>
    </div>

    <!-- Navigation buttons -->
    <div class="links">
      <a href="/admin/users" class="link-btn">Manage Users</a>
      <a href="/admin/applications" class="link-btn">Review Applications</a>
    </div>
  </div>

  <footer>
    &copy; <?= date('Y') ?> Municipality of Naujan | Scholarship Management System
  </footer>

</body>
</html>
