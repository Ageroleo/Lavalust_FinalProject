<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Applications - Applicant</title>
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
      background: #f3f4f6;
      color: var(--text-primary);
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
    }

    /* Sidebar Styles */
    .sidebar {
      width: var(--sidebar-width);
      background-color: #ffffff;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      z-index: 50;
      transition: transform 0.3s ease;
    }

    .sidebar-brand {
      height: var(--header-height);
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      border-bottom: 1px solid var(--border);
    }

    .sidebar-brand h2 {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .sidebar-nav {
      padding: 1.5rem 1rem;
      flex: 1;
    }

    .nav-item {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      color: var(--text-secondary);
      text-decoration: none;
      border-radius: 0.75rem;
      margin-bottom: 0.5rem;
      font-weight: 500;
      transition: all 0.2s;
    }

    .nav-item:hover, .nav-item.active {
      background-color: #e8f5e9;
      color: var(--primary);
    }

    .nav-item i {
      width: 24px;
      margin-right: 12px;
    }

    .sidebar-footer {
      padding: 1.5rem;
      border-top: 1px solid var(--border);
    }

    .user-mini-profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .avatar {
      width: 40px;
      height: 40px;
      background-color: #e8f5e9;
      color: var(--primary);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 1.1rem;
    }

    .user-info h4 {
      font-size: 0.9rem;
      font-weight: 600;
    }

    .user-info span {
      font-size: 0.75rem;
      color: var(--text-secondary);
      display: block;
    }

    /* Main Content Styles */
    .main-content {
      flex: 1;
      margin-left: var(--sidebar-width);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Header */
    header {
      height: var(--header-height);
      background-color: #ffffff;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 40;
    }

    .header-title h1 {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--text-primary);
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .btn-logout {
      padding: 0.5rem 1rem;
      border: 1px solid var(--border);
      background: white;
      color: var(--text-primary);
      border-radius: 6px;
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-logout:hover {
      background-color: #fee2e2;
      border-color: #fecaca;
      color: #ef4444;
    }

    .mobile-menu-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--text-primary);
      cursor: pointer;
    }

    /* Modern container and page layout */
    .page-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 2rem;
      flex: 1;
      width: 100%;
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

    /* Modern action button */
    .btn-view {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      transition: var(--transition);
    }

    .btn-view:hover {
      background: var(--primary-dark);
      box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
      transform: translateY(-1px);
    }

    /* Delete button styling */
    .btn-delete {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      background: #ef4444;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      transition: var(--transition);
    }

    .btn-delete:hover {
      background: #dc2626;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
      transform: translateY(-1px);
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

    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      transition: var(--transition);
    }

    .btn-primary:hover {
      background: var(--primary-dark);
      box-shadow: 0 6px 20px rgba(46, 125, 50, 0.3);
      transform: translateY(-2px);
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
    @media (max-width: 1024px) {
      :root {
        --sidebar-width: 0px;
      }

      .sidebar {
        transform: translateX(-100%);
        width: 260px;
      }

      .sidebar.active {
        transform: translateX(0);
        width: 260px;
        box-shadow: 0 0 50px rgba(0,0,0,0.5);
      }

      .main-content {
        margin-left: 0;
      }

      .mobile-menu-toggle {
        display: block;
      }

      .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0,0,0,0.4);
        z-index: 45;
      }
      
      .overlay.active {
        display: block;
      }
    }

    @media (max-width: 768px) {
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
        min-width: 700px;
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
    }
  </style>
</head>
<body>

    <!-- Mobile Overlay -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2><i class="fas fa-graduation-cap"></i> Naujan<span style="font-weight:300">Educational Assistance</span></h2>
        </div>
        
        <nav class="sidebar-nav">
            <a href="/applicant/dashboard" class="nav-item">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?? '' ?>/apply/form" class="nav-item">
                <i class="fas fa-file-signature"></i> Apply Now
            </a>
            <a href="/applicant/my-applications" class="nav-item active">
                <i class="fas fa-folder-open"></i> My Applications
            </a>
            <a href="/applicant/profile" class="nav-item">
                <i class="fas fa-user-circle"></i> Profile
            </a>
            <a href="/applicant/settings" class="nav-item">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-mini-profile">
                <div class="avatar">
                    <?php 
                        $fullname = $_SESSION['user']['fullname'] ?? 'Guest User';
                        $initial = strtoupper(substr($fullname, 0, 1));
                        echo $initial;
                    ?>
                </div>
                <div class="user-info">
                    <h4><?= htmlspecialchars($fullname) ?></h4>
                    <span>Applicant</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <div class="header-title">
                <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 style="display:inline-block; margin-left: 10px;">My Applications</h1>
            </div>
            
            <div class="header-actions">
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>

        <!-- Modern page container -->
        <div class="page-container">
    <div class="page-header">
      <h2 class="page-title">
        <i class="fas fa-folder-open"></i>
        My Applications
      </h2>
      <p class="page-subtitle">Track and manage all your scholarship applications</p>
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
          <h3>No Applications Yet</h3>
          <p>You haven't submitted any scholarship applications. Start your journey today!</p>
          <a href="/apply/form" class="btn-primary">
            <i class="fas fa-plus"></i>
            Apply for Scholarship
          </a>
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
              <th>Applicant Name</th>
              <th>School</th>
              <th>Submitted Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($applications as $app): ?>
              <tr>
                <td>
                  <strong><?= htmlspecialchars(($app['first_name'] ?? '') . ' ' . ($app['last_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></strong>
                </td>
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
                  <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                    <a href="/applicant/view-application/<?= $app['id'] ?? '' ?>" class="btn-view">
                      <i class="fas fa-eye"></i>
                      View Details
                    </a>
                    <a href="/applicant/delete-application/<?= $app['id'] ?? '' ?>" 
                       class="btn-delete" 
                       onclick="return confirm('Are you sure you want to delete this application? This action cannot be undone.');">
                      <i class="fas fa-trash"></i>
                      Delete
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
        </div>
    </main>

    <script>
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.overlay').classList.toggle('active');
        }

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.alert');
            if (alerts.length > 0) {
                setTimeout(() => {
                    alerts.forEach(alert => {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        alert.style.transition = 'all 0.5s ease';
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 5000);
            }
        });
    </script>

</body>
</html>
