<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review Applications - Admin</title>
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

    .logout, .back-link {
      position: absolute;
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

    .back-link {
      left: 25px;
    }

    .logout {
      right: 25px;
    }

    .logout:hover, .back-link:hover {
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
      margin-bottom: 25px;
      font-size: 22px;
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

    .applications-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .applications-table th,
    .applications-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #e0e0e0;
    }

    .applications-table th {
      background: #f1f8e9;
      color: #33691e;
      font-weight: 600;
    }

    .applications-table tr:hover {
      background: #f9fbe7;
    }

    .status-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .status-pending {
      background: #fff3e0;
      color: #e65100;
    }

    .status-approved {
      background: #e8f5e9;
      color: #1b5e20;
    }

    .status-rejected {
      background: #ffebee;
      color: #b71c1c;
    }

    .btn-group {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .btn-view {
      background: #2196f3;
      color: #fff;
    }

    .btn-view:hover {
      background: #1976d2;
    }

    .btn-approve {
      background: #4caf50;
      color: #fff;
    }

    .btn-approve:hover {
      background: #388e3c;
    }

    .btn-reject {
      background: #f44336;
      color: #fff;
    }

    .btn-reject:hover {
      background: #c62828;
    }

    .btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .empty-state {
      text-align: center;
      padding: 40px;
      color: #666;
    }

    footer {
      text-align: center;
      padding: 20px;
      margin-top: auto;
      color: #666;
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .applications-table {
        font-size: 14px;
      }

      .applications-table th,
      .applications-table td {
        padding: 8px;
      }

      .btn-group {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <header>
    <a href="/admin/dashboard" class="back-link">← Back</a>
    <h1>Naujan Scholarship System</h1>
    <p>Review Applications</p>
    <a href="/logout" class="logout">Logout</a>
  </header>

  <div class="container">
    <h2>All Applications</h2>

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

    <?php if (empty($applications)): ?>
      <div class="empty-state">
        <p>No applications found.</p>
      </div>
    <?php else: ?>
      <table class="applications-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>School</th>
            <th>Date Submitted</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($applications as $app): ?>
            <tr>
              <td><?= htmlspecialchars($app['id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars(($app['first_name'] ?? '') . ' ' . ($app['last_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($app['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($app['school_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= isset($app['date_submitted']) ? date('M d, Y', strtotime($app['date_submitted'])) : 'N/A' ?></td>
              <td>
                <?php
                $status = $app['status'] ?? 'pending';
                $statusClass = 'status-pending';
                if ($status === 'Approved') {
                  $statusClass = 'status-approved';
                } elseif ($status === 'Rejected') {
                  $statusClass = 'status-rejected';
                }
                ?>
                <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></span>
              </td>
              <td>
                <div class="btn-group">
                  <a href="/admin/view/<?= $app['id'] ?? '' ?>" class="btn btn-view">View</a>
                  <?php if ($status === 'pending'): ?>
                    <a href="/admin/approve/<?= $app['id'] ?? '' ?>" class="btn btn-approve" onclick="return confirm('Are you sure you want to approve this application?')">Approve</a>
                    <a href="/admin/reject/<?= $app['id'] ?? '' ?>" class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this application?')">Reject</a>
                  <?php else: ?>
                    <span class="btn btn-approve" style="opacity: 0.5; cursor: not-allowed;">Approve</span>
                    <span class="btn btn-reject" style="opacity: 0.5; cursor: not-allowed;">Reject</span>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <footer>
    &copy; <?= date('Y') ?> Municipality of Naujan | Scholarship Management System
  </footer>

</body>
</html>

