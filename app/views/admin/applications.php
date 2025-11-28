<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review Applications - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Modern reset and CSS variables */
    :root {
      --primary: #2e7d32;
      --primary-dark: #1b5e20;
      --primary-light: #4caf50;
      --bg-main: #f8faf9;
      --bg-card: #ffffff;
      --text-primary: #1a1a1a;
      --text-secondary: #666666;
      --border: #e5e7eb;
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
      --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.15);
      --radius: 12px;
      --sidebar-width: 260px;
      --header-height: 70px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--bg-main);
      color: var(--text-primary);
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Modern header with better layout */
    header {
      background: var(--bg-card);
      border-bottom: 1px solid var(--border);
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: var(--shadow-sm);
    }

    .header-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      height: var(--header-height);
      max-width: 1400px;
      margin: 0 auto;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .logo-section {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .logo-icon {
      width: 42px;
      height: 42px;
      background: linear-gradient(135deg, var(--primary), var(--primary-light));
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 20px;
    }

    .logo-text h1 {
      font-size: 18px;
      font-weight: 700;
      color: var(--text-primary);
      line-height: 1.2;
    }

    .logo-text p {
      font-size: 12px;
      color: var(--text-secondary);
      font-weight: 500;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .back-link {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      background: transparent;
      color: var(--text-secondary);
      border: 1px solid var(--border);
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      font-size: 14px;
      transition: var(--transition);
    }

    .back-link:hover {
      background: var(--bg-main);
      color: var(--primary);
      border-color: var(--primary);
    }

    /* Modern user menu */
    .user-menu {
      position: relative;
    }

    .user-menu-toggle {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      background: var(--bg-main);
      border: 1px solid var(--border);
      padding: 0.5rem 1rem;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 500;
      font-size: 14px;
      color: var(--text-primary);
      transition: var(--transition);
    }

    .user-menu-toggle:hover {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--primary-light));
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 14px;
    }

    .user-menu-toggle .fa-chevron-down {
      font-size: 10px;
      transition: transform 0.3s ease;
    }

    .user-menu-toggle.active .fa-chevron-down {
      transform: rotate(180deg);
    }

    .dropdown-menu {
      position: absolute;
      top: calc(100% + 0.5rem);
      right: 0;
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow-lg);
      min-width: 220px;
      display: none;
      z-index: 1000;
      overflow: hidden;
      animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .dropdown-menu.active {
      display: block;
    }

    .dropdown-menu a {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.875rem 1.25rem;
      color: var(--text-primary);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: var(--transition);
      border-bottom: 1px solid var(--border);
    }

    .dropdown-menu a:last-child {
      border-bottom: none;
    }

    .dropdown-menu a:hover {
      background: var(--bg-main);
      color: var(--primary);
    }

    .dropdown-menu a i {
      width: 18px;
      text-align: center;
      font-size: 16px;
    }

    .dropdown-menu a.logout-item {
      color: #dc2626;
    }

    .dropdown-menu a.logout-item:hover {
      background: #fef2f2;
      color: #b91c1c;
    }

    /* Modern container and page layout */
    .page-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 2rem;
      flex: 1;
    }

    .page-header {
      margin-bottom: 2rem;
    }

    .page-title {
      font-size: 28px;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .page-title i {
      color: var(--primary);
    }

    .page-subtitle {
      color: var(--text-secondary);
      font-size: 15px;
    }

    /* Modern alert styling */
    .alert {
      padding: 1rem 1.25rem;
      border-radius: var(--radius);
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 14px;
      font-weight: 500;
      border: 1px solid;
      animation: slideIn 0.4s ease;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert i {
      font-size: 18px;
    }

    .alert-success {
      background: #f0fdf4;
      border-color: #86efac;
      color: #166534;
    }

    .alert-error {
      background: #fef2f2;
      border-color: #fca5a5;
      color: #991b1b;
    }

    /* Modern table card wrapper */
    .table-card {
      background: var(--bg-card);
      border-radius: var(--radius);
      box-shadow: var(--shadow-md);
      overflow: hidden;
      border: 1px solid var(--border);
    }

    .table-header {
      padding: 1.5rem;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .table-header h3 {
      font-size: 18px;
      font-weight: 600;
      color: var(--text-primary);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .applications-count {
      background: var(--primary);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
    }

    /* Modern table styling */
    .applications-table {
      width: 100%;
      border-collapse: collapse;
    }

    .applications-table th {
      background: var(--bg-main);
      padding: 1rem 1.5rem;
      text-align: left;
      font-weight: 600;
      font-size: 13px;
      color: var(--text-secondary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 1px solid var(--border);
    }

    .applications-table td {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid var(--border);
      font-size: 14px;
      color: var(--text-primary);
    }

    .applications-table tbody tr {
      transition: var(--transition);
    }

    .applications-table tbody tr:hover {
      background: var(--bg-main);
    }

    .applications-table tbody tr:last-child td {
      border-bottom: none;
    }

    /* Modern status badges with icons */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.375rem 0.875rem;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: capitalize;
    }

    .status-pending {
      background: #fef3c7;
      color: #92400e;
    }

    .status-approved {
      background: #d1fae5;
      color: #065f46;
    }

    .status-rejected {
      background: #fee2e2;
      color: #991b1b;
    }

    /* Modern action buttons */
    .btn-group {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      transition: var(--transition);
    }

    .btn-view {
      background: #2196f3;
      color: white;
    }

    .btn-view:hover {
      background: #1976d2;
      box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
      transform: translateY(-1px);
    }

    .btn-approve {
      background: #4caf50;
      color: white;
    }

    .btn-approve:hover {
      background: #388e3c;
      box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
      transform: translateY(-1px);
    }

    .btn-reject {
      background: #f44336;
      color: white;
    }

    .btn-reject:hover {
      background: #c62828;
      box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
      transform: translateY(-1px);
    }

    .btn:disabled,
    .btn.disabled {
      opacity: 0.5;
      cursor: not-allowed;
      pointer-events: none;
    }

    /* Modern empty state */
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
    }

    .empty-state-icon {
      width: 120px;
      height: 120px;
      margin: 0 auto 1.5rem;
      background: linear-gradient(135deg, #f0fdf4, #dcfce7);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 48px;
      color: var(--primary);
    }

    .empty-state h3 {
      font-size: 20px;
      color: var(--text-primary);
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .empty-state p {
      color: var(--text-secondary);
      margin-bottom: 1.5rem;
      font-size: 15px;
    }

    /* Modern footer */
    footer {
      text-align: center;
      padding: 2rem;
      color: var(--text-secondary);
      font-size: 14px;
      border-top: 1px solid var(--border);
      background: var(--bg-card);
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
      .header-content {
        padding: 0 1rem;
      }

      .logo-text h1 {
        font-size: 16px;
      }

      .logo-text p {
        display: none;
      }

      .back-link span {
        display: none;
      }

      .user-menu-toggle span {
        display: none;
      }

      .page-container {
        padding: 1rem;
      }

      .page-title {
        font-size: 22px;
      }

      .table-card {
        overflow-x: auto;
      }

      .applications-table {
        min-width: 800px;
      }

      .applications-table th,
      .applications-table td {
        padding: 0.875rem 1rem;
        font-size: 13px;
      }
    }

    @media (max-width: 480px) {
      .page-container {
        padding: 0.75rem;
      }

      .page-title {
        font-size: 20px;
      }

      .applications-table th,
      .applications-table td {
        padding: 0.75rem 0.875rem;
        font-size: 12px;
      }

      .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 12px;
      }

      .btn-group {
        flex-direction: column;
      }

      .btn {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>

  <!-- Modern header with better structure -->
  <header>
    <div class="header-content">
      <div class="header-left">
        <div class="logo-section">
          <div class="logo-icon">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <div class="logo-text">
            <h1>NEAP Portal</h1>
            <p>Admin Dashboard</p>
          </div>
        </div>
      </div>
      <div class="header-right">
        <a href="/admin/dashboard" class="back-link">
          <i class="fas fa-arrow-left"></i>
          <span>Back to Dashboard</span>
        </a>
        <div class="user-menu">
          <button class="user-menu-toggle" onclick="toggleUserMenu()">
            <div class="user-avatar">
              <?= strtoupper(substr($_SESSION['user']['fullname'] ?? 'A', 0, 1)) ?>
            </div>
            <span><?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'Administrator', ENT_QUOTES, 'UTF-8') ?></span>
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="dropdown-menu" id="userDropdown">
            <a href="/admin/dashboard">
              <i class="fas fa-th-large"></i>
              Dashboard
            </a>
            <a href="/admin/applications">
              <i class="fas fa-file-alt"></i>
              Applications
            </a>
            <a href="/admin/users">
              <i class="fas fa-users"></i>
              Manage Users
            </a>
            <a href="/logout" class="logout-item">
              <i class="fas fa-sign-out-alt"></i>
              Logout
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Modern page container -->
  <div class="page-container">
    <div class="page-header">
      <h2 class="page-title">
        <i class="fas fa-clipboard-list"></i>
        Review Applications
      </h2>
      <p class="page-subtitle">Review and manage all scholarship applications</p>
    </div>

    <?php if (!empty($_SESSION['success_message'])): ?>
      <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span><?= htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?></span>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8'); ?></span>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (empty($applications)): ?>
      <!-- Modern empty state -->
      <div class="table-card">
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fas fa-inbox"></i>
          </div>
          <h3>No Applications Found</h3>
          <p>There are no scholarship applications to review at this time.</p>
        </div>
      </div>
    <?php else: ?>
      <!-- Modern table card -->
      <div class="table-card">
        <div class="table-header">
          <h3>
            All Applications
            <span class="applications-count"><?= count($applications) ?></span>
          </h3>
        </div>
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
                <td>
                  <strong><?= htmlspecialchars(($app['first_name'] ?? '') . ' ' . ($app['last_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></strong>
                </td>
                <td><?= htmlspecialchars($app['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($app['school_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= isset($app['date_submitted']) ? date('M d, Y', strtotime($app['date_submitted'])) : 'N/A' ?></td>
                <td>
                  <?php
                  $status = strtolower($app['status'] ?? 'pending');
                  $statusClass = 'status-pending';
                  $statusIcon = 'fa-clock';
                  $statusText = 'Pending';
                  
                  if ($status === 'approved') {
                    $statusClass = 'status-approved';
                    $statusIcon = 'fa-check-circle';
                    $statusText = 'Approved';
                  } elseif ($status === 'rejected') {
                    $statusClass = 'status-rejected';
                    $statusIcon = 'fa-times-circle';
                    $statusText = 'Rejected';
                  }
                  ?>
                  <span class="status-badge <?= $statusClass ?>">
                    <i class="fas <?= $statusIcon ?>"></i>
                    <?= $statusText ?>
                  </span>
                </td>
                <td>
                  <div class="btn-group">
                    <a href="/admin/view/<?= $app['id'] ?? '' ?>" class="btn btn-view">
                      <i class="fas fa-eye"></i>
                      View
                    </a>
                    <?php if ($status === 'pending'): ?>
                      <a href="/admin/approve/<?= $app['id'] ?? '' ?>" class="btn btn-approve" onclick="return confirm('Are you sure you want to approve this application?')">
                        <i class="fas fa-check"></i>
                        Approve
                      </a>
                      <a href="/admin/reject/<?= $app['id'] ?? '' ?>" class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this application?')">
                        <i class="fas fa-times"></i>
                        Reject
                      </a>
                    <?php else: ?>
                      <span class="btn btn-approve disabled">
                        <i class="fas fa-check"></i>
                        Approve
                      </span>
                      <span class="btn btn-reject disabled">
                        <i class="fas fa-times"></i>
                        Reject
                      </span>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <footer>
    <p>&copy; <?= date('Y') ?> Municipality of Naujan | Educational Assistance Program</p>
  </footer>

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
      const toggle = document.querySelector('.user-menu-toggle');
      
      if (userMenu && !userMenu.contains(event.target)) {
        dropdown.classList.remove('active');
        toggle.classList.remove('active');
      }
    });

    // Close dropdown with ESC key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        document.getElementById('userDropdown').classList.remove('active');
        document.querySelector('.user-menu-toggle').classList.remove('active');
      }
    });
  </script>

</body>
</html>
