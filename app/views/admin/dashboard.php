<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
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
      max-width: 1200px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      animation: fadeIn 0.6s ease-in-out;
      margin-bottom: 40px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      color: #1b5e20;
      margin-bottom: 30px;
      font-size: 28px;
    }

    .stats-section {
      margin-bottom: 40px;
    }

    .stats-title {
      text-align: center;
      color: #33691e;
      font-size: 20px;
      margin-bottom: 25px;
      font-weight: 600;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      margin-bottom: 30px;
    }

    .card {
      background: linear-gradient(135deg, #f1f8e9, #fff);
      border-radius: 12px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .card.total {
      border-color: #2196f3;
      background: linear-gradient(135deg, #e3f2fd, #fff);
    }

    .card.pending {
      border-color: #ff9800;
      background: linear-gradient(135deg, #fff3e0, #fff);
    }

    .card.approved {
      border-color: #4caf50;
      background: linear-gradient(135deg, #e8f5e9, #fff);
    }

    .card.rejected {
      border-color: #f44336;
      background: linear-gradient(135deg, #ffebee, #fff);
    }

    .card-icon {
      font-size: 48px;
      margin-bottom: 15px;
    }

    .card h3 {
      color: #555;
      font-size: 16px;
      margin-bottom: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .card .number {
      font-size: 42px;
      font-weight: bold;
      color: #1b5e20;
      display: block;
      margin-bottom: 8px;
    }

    .card.total .number {
      color: #1976d2;
    }

    .card.pending .number {
      color: #f57c00;
    }

    .card.approved .number {
      color: #2e7d32;
    }

    .card.rejected .number {
      color: #c62828;
    }

    .card .label {
      font-size: 14px;
      color: #777;
    }

    .links {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 30px;
      padding-top: 30px;
      border-top: 2px solid #e0e0e0;
    }

    .link-btn {
      display: inline-block;
      padding: 14px 28px;
      background: linear-gradient(90deg, #43a047, #66bb6a);
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s ease;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .link-btn:hover {
      background: linear-gradient(90deg, #388e3c, #43a047);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .link-btn.secondary {
      background: linear-gradient(90deg, #2196f3, #42a5f5);
    }

    .link-btn.secondary:hover {
      background: linear-gradient(90deg, #1976d2, #2196f3);
    }

    footer {
      text-align: center;
      padding: 20px;
      margin-top: auto;
      color: #666;
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .cards {
        grid-template-columns: 1fr;
      }
      
      .card {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>Naujan Scholarship System</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'Administrator', ENT_QUOTES, 'UTF-8') ?></p>
    <a href="/logout" class="logout">Logout</a>
  </header>

  <div class="container">
    <h2>Admin Dashboard</h2>

    <div class="stats-section">
      <div class="stats-title">Application Statistics</div>
      
      <div class="cards">
        <div class="card total">
          <div class="card-icon">📊</div>
          <h3>Total Applications</h3>
          <span class="number"><?= isset($statistics) ? number_format($statistics['total']) : 0 ?></span>
          <span class="label">All submitted applications</span>
        </div>

        <div class="card pending">
          <div class="card-icon">⏳</div>
          <h3>Pending Applications</h3>
          <span class="number"><?= isset($statistics) ? number_format($statistics['pending']) : 0 ?></span>
          <span class="label">Awaiting review</span>
        </div>

        <div class="card approved">
          <div class="card-icon">✅</div>
          <h3>Approved Applications</h3>
          <span class="number"><?= isset($statistics) ? number_format($statistics['approved']) : 0 ?></span>
          <span class="label">Successfully approved</span>
        </div>

        <div class="card rejected">
          <div class="card-icon">❌</div>
          <h3>Rejected Applications</h3>
          <span class="number"><?= isset($statistics) ? number_format($statistics['rejected']) : 0 ?></span>
          <span class="label">Not approved</span>
        </div>
      </div>
    </div>

    <!-- Navigation buttons -->
    <div class="links">
      <a href="/admin/applications" class="link-btn">Review Applications</a>
      <a href="/admin/users" class="link-btn secondary">Manage Users</a>
    </div>
  </div>

  <footer>
    &copy; <?= date('Y') ?> Municipality of Naujan | Scholarship Management System
  </footer>

</body>
</html>

