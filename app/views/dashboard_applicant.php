<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Applicant Dashboard - Naujan Scholarship System</title>
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
      background: #2e7d32;
      color: #fff;
      width: 100%;
      padding: 20px 0;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    header h1 {
      font-size: 24px;
      margin-bottom: 5px;
    }

    header p {
      font-size: 15px;
      opacity: 0.9;
    }

    .container {
      background: #fff;
      margin-top: 40px;
      padding: 30px;
      width: 90%;
      max-width: 800px;
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
      color: #2e7d32;
      margin-bottom: 25px;
      font-size: 22px;
    }

    .actions {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
    }

    .card {
      background: #f9fbe7;
      border-radius: 10px;
      padding: 25px;
      width: 250px;
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
      margin-bottom: 10px;
    }

    .card p {
      color: #555;
      font-size: 14px;
      margin-bottom: 15px;
    }

    .alert {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px 18px;
      border-radius: 8px;
      font-size: 14px;
      border: 1px solid transparent;
    }

    .alert-success {
      background: #e8f5e9;
      border-color: #c8e6c9;
      color: #1b5e20;
    }

    .alert-error {
      background: #ffebee;
      border-color: #ffcdd2;
      color: #b71c1c;
    }

    .btn-apply {
  display: inline-block;
  padding: 12px 25px;
  background: hsl(86, 65%, 54%);
  color: #fff;
  text-decoration: none;
  border-radius: 6px;
  font-weight: bold;
  transition: 0.3s ease;
}
.btn-apply:hover {
  background: hsl(86, 55%, 45%);
    }
adow: 0 3px 10px rgba(0,0,0,0.2);

    footer {
      text-align: center;
      padding: 20px;
      margin-top: 40px;
      color: #666;
      font-size: 14px;
    }

    .logout {
      position: absolute;
      right: 30px;
      top: 25px;
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      border: 1px solid #fff;
      padding: 6px 12px;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    .logout:hover {
      background: #fff;
      color: #2e7d32;
    }

    @media (max-width: 600px) {
      .card { width: 100%; }
    }
  </style>
</head>

<body>

  <header>
    <h1>Naujan Scholarship System</h1>
    <p>Welcome Applicant</p>
    <a href="/logout" class="logout">Logout</a>
  </header>

  <div class="container">
    <h2>Applicant Dashboard</h2>

    <?php if (!empty($_SESSION['success_message'])): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8'); ?>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="actions">
      <div class="card">
        <h3>Apply for Scholarship</h3>
        <p>Submit your scholarship application and upload required documents.</p>
        <a href="<?= BASE_URL ?>/apply/form" class="btn-apply">Apply for Scholarship</a>
      </div>

      <div class="card">
        <h3>My Applications</h3>
        <p>View your current and previous applications and their statuses.</p>
        <a href="/applicant/my-applications" class="btn-apply">View Applications</a>
      </div>

      <div class="card">
        <h3>Profile</h3>
        <p>Update your personal details and contact information.</p>
        <a href="/applicant/profile" class="btn-apply">View Profile</a>
      </div>
    </div>
  </div>

  <footer>
    &copy; <?= date('Y') ?> Municipality of Naujan | Educational Assistance Program
  </footer>

</body>
</html>
