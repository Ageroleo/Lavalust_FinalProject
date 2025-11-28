<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Application - Admin</title>
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

    /* Modern card styling */
    .card {
      background: var(--bg-card);
      border-radius: var(--radius);
      box-shadow: var(--shadow-md);
      border: 1px solid var(--border);
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    /* Card with empty state - match table-card sizing */
    .card.empty-state-card {
      min-height: 400px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 0;
    }

    .card.empty-state-card .empty-state {
      width: 100%;
      padding: 4rem 2rem;
    }

    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--border);
    }

    .card-title {
      font-size: 20px;
      font-weight: 600;
      color: var(--text-primary);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .card-title i {
      color: var(--primary);
    }

    /* Status badge */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 13px;
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

    /* Info grid */
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1rem;
      margin-bottom: 1rem;
    }

    @media (min-width: 1200px) {
      .info-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (min-width: 1600px) {
      .info-grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    .info-item {
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    .info-label {
      font-weight: 600;
      color: var(--text-secondary);
      margin-bottom: 0.5rem;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .info-value {
      color: var(--text-primary);
      padding: 0.75rem 1rem;
      background: var(--bg-main);
      border-radius: 8px;
      font-size: 14px;
      min-height: 44px;
      display: flex;
      align-items: center;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }

    /* Essay box */
    .essay-box {
      background: var(--bg-main);
      padding: 1.25rem;
      border-radius: var(--radius);
      border-left: 4px solid var(--primary);
      margin-top: 0.5rem;
      white-space: pre-wrap;
      line-height: 1.7;
      font-size: 14px;
      color: var(--text-primary);
    }

    /* File list */
    .file-list {
      margin-top: 1rem;
    }

    .file-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      padding: 1rem;
      background: var(--bg-main);
      border-radius: 8px;
      margin-bottom: 0.75rem;
      border: 1px solid var(--border);
      transition: var(--transition);
    }

    .file-item:hover {
      border-color: var(--primary);
      box-shadow: var(--shadow-sm);
    }

    .file-label {
      font-weight: 600;
      color: var(--text-primary);
      font-size: 14px;
      flex: 1;
    }

    .file-link {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      background: var(--primary);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      transition: var(--transition);
    }

    .file-link:hover {
      background: var(--primary-dark);
      box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
      transform: translateY(-1px);
    }

    /* Action buttons */
    .action-buttons {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--border);
      flex-wrap: wrap;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      transition: var(--transition);
    }

    .btn-back {
      background: #2196f3;
      color: white;
    }

    .btn-back:hover {
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

      .info-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
      }

      .info-value {
        padding: 0.875rem 1rem;
        font-size: 13px;
      }

      .action-buttons {
        flex-direction: column;
        gap: 0.75rem;
      }

      .action-buttons .btn {
        width: 100%;
      }
    }

    @media (max-width: 480px) {
      .page-container {
        padding: 0.75rem;
      }

      .page-title {
        font-size: 20px;
      }

      .info-value {
        padding: 0.75rem;
        font-size: 12px;
      }

      .file-list-item {
        padding: 0.75rem;
      }
      }

      .btn {
        width: 100%;
        justify-content: center;
      }

      .file-item {
        flex-direction: column;
        align-items: flex-start;
      }

      .file-link {
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
        <a href="/admin/applications" class="back-link">
          <i class="fas fa-arrow-left"></i>
          <span>Back to Applications</span>
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
        <i class="fas fa-file-alt"></i>
        Application Details
      </h2>
      <p class="page-subtitle">Review application information and documents</p>
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

    <?php if (empty($application)): ?>
      <div class="card empty-state-card">
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fas fa-file-alt"></i>
          </div>
          <h3>Application Not Found</h3>
          <p>The application you're looking for doesn't exist or has been removed.</p>
        </div>
      </div>
    <?php else: ?>
      <!-- Application Header Card -->
      <div class="card">
        <div class="card-header">
          <div>
            <h3 class="card-title">
              <i class="fas fa-hashtag"></i>
              Application #<?= htmlspecialchars($application['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>
            </h3>
          </div>
          <div>
            <?php
            $status = strtolower($application['status'] ?? 'pending');
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
          </div>
        </div>
      </div>

      <!-- Personal Information Card -->
      <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">
          <i class="fas fa-user"></i>
          Personal Information
        </h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Last Name</span>
            <span class="info-value"><?= htmlspecialchars($application['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">First Name</span>
            <span class="info-value"><?= htmlspecialchars($application['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Middle Name</span>
            <span class="info-value"><?= htmlspecialchars($application['middle_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Email</span>
            <span class="info-value"><?= htmlspecialchars($application['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Contact Number</span>
            <span class="info-value"><?= htmlspecialchars($application['contact_no'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Birthday</span>
            <span class="info-value"><?= isset($application['birthday']) ? date('M d, Y', strtotime($application['birthday'])) : 'N/A' ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Age</span>
            <span class="info-value"><?= htmlspecialchars($application['age'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Civil Status</span>
            <span class="info-value"><?= htmlspecialchars($application['civil_status'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Place of Birth</span>
            <span class="info-value"><?= htmlspecialchars($application['birth_place'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Height (cm)</span>
            <span class="info-value"><?= htmlspecialchars($application['height'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Weight (kg)</span>
            <span class="info-value"><?= htmlspecialchars($application['weight'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Special Skills</span>
            <span class="info-value"><?= htmlspecialchars($application['special_skills'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
        <div class="info-item" style="margin-top: 1rem;">
          <span class="info-label">Home Address</span>
          <span class="info-value"><?= htmlspecialchars($application['address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      </div>

      <!-- Educational Background Card -->
      <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">
          <i class="fas fa-graduation-cap"></i>
          Educational Background
        </h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">School/University</span>
            <span class="info-value"><?= htmlspecialchars($application['school_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Year Level</span>
            <span class="info-value"><?= htmlspecialchars($application['year_level'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">School Type</span>
            <span class="info-value"><?= htmlspecialchars($application['school_type'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Course/Major</span>
            <span class="info-value"><?= htmlspecialchars($application['course'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Academic Standing</span>
            <span class="info-value"><?= htmlspecialchars($application['academic_standing'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      </div>

      <!-- Essay Card -->
      <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">
          <i class="fas fa-file-alt"></i>
          Essay
        </h3>
        <div class="essay-box"><?= htmlspecialchars($application['essay'] ?? 'No essay provided.', ENT_QUOTES, 'UTF-8') ?></div>
      </div>

      <!-- Service Obligation Card -->
      <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">
          <i class="fas fa-handshake"></i>
          Service Obligation
        </h3>
        <div class="info-value"><?= htmlspecialchars($application['service_obligation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></div>
      </div>

      <!-- Family Background Card -->
      <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">
          <i class="fas fa-users"></i>
          Family Background
        </h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Father's Name</span>
            <span class="info-value"><?= htmlspecialchars($application['father_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Father's Occupation</span>
            <span class="info-value"><?= htmlspecialchars($application['father_occupation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Mother's Name</span>
            <span class="info-value"><?= htmlspecialchars($application['mother_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Mother's Occupation</span>
            <span class="info-value"><?= htmlspecialchars($application['mother_occupation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Parent Contact Number</span>
            <span class="info-value"><?= htmlspecialchars($application['parent_contact'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Parent Address</span>
            <span class="info-value"><?= htmlspecialchars($application['parent_address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Household Annual Income</span>
            <span class="info-value"><?= htmlspecialchars($application['annual_income'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      </div>

      <!-- Parent/Guardian Information Card -->
      <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">
          <i class="fas fa-user-shield"></i>
          Parent/Guardian Information
        </h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Guardian Name</span>
            <span class="info-value"><?= htmlspecialchars($application['guardian_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Relationship</span>
            <span class="info-value"><?= htmlspecialchars($application['guardian_relationship'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Contact Number</span>
            <span class="info-value"><?= htmlspecialchars($application['guardian_contact'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Address</span>
            <span class="info-value"><?= htmlspecialchars($application['guardian_address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      </div>

      <!-- Uploaded Documents Card -->
      <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">
          <i class="fas fa-file-upload"></i>
          Uploaded Documents
        </h3>
        <?php
        $uploaded_files = [];
        if (!empty($application['uploaded_files'])) {
          $uploaded_files = json_decode($application['uploaded_files'], true);
        }
        $file_labels = [
          'affidavit_file' => 'Affidavit of Undertaking',
          'birth_certificate' => 'Birth Certificate (PSA/LCR)',
          'residency_cert' => 'Certificate of Residency',
          'guardian_id' => 'Parent/Guardian ID',
          'enrollment_cert' => 'Certificate of Enrollment',
          'good_moral' => 'Certificate of Good Moral Character',
          'transcript' => 'Transcript of Records / Grades'
        ];
        ?>
        <div class="file-list">
          <?php if (!empty($uploaded_files)): ?>
            <?php foreach ($file_labels as $key => $label): ?>
              <?php if (!empty($uploaded_files[$key])): ?>
                <div class="file-item">
                  <span class="file-label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
                  <a href="/public/uploads/<?= htmlspecialchars($uploaded_files[$key], ENT_QUOTES, 'UTF-8') ?>" 
                     target="_blank" 
                     class="file-link">
                    <i class="fas fa-external-link-alt"></i>
                    View File
                  </a>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="color: var(--text-secondary); padding: 1rem; background: var(--bg-main); border-radius: 8px;">No files uploaded.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Application Details Card -->
      <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">
          <i class="fas fa-info-circle"></i>
          Application Details
        </h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Date Submitted</span>
            <span class="info-value"><?= isset($application['date_submitted']) ? date('M d, Y h:i A', strtotime($application['date_submitted'])) : 'N/A' ?></span>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="action-buttons">
        <a href="/admin/applications" class="btn btn-back">
          <i class="fas fa-arrow-left"></i>
          Back to Applications
        </a>
        <?php if (($application['status'] ?? 'pending') === 'pending'): ?>
          <a href="/admin/approve/<?= $application['id'] ?? '' ?>" 
             class="btn btn-approve" 
             onclick="return confirm('Are you sure you want to approve this application?')">
            <i class="fas fa-check"></i>
            Approve Application
          </a>
          <a href="/admin/reject/<?= $application['id'] ?? '' ?>" 
             class="btn btn-reject" 
             onclick="return confirm('Are you sure you want to reject this application?')">
            <i class="fas fa-times"></i>
            Reject Application
          </a>
        <?php else: ?>
          <span class="btn btn-approve disabled">
            <i class="fas fa-info-circle"></i>
            Application Already <?= htmlspecialchars(ucfirst($application['status'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
          </span>
        <?php endif; ?>
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
