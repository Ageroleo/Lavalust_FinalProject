<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users - Admin</title>
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

    /* Search section */
    .search-section {
      margin-bottom: 1.5rem;
    }

    .search-form {
      display: flex;
      gap: 0.75rem;
      flex-wrap: wrap;
    }

    .search-input {
      flex: 1;
      min-width: 300px;
      padding: 0.75rem 1rem;
      border: 2px solid var(--border);
      border-radius: 8px;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      transition: var(--transition);
    }

    .search-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
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

    .btn-search {
      background: var(--primary);
      color: white;
    }

    .btn-search:hover {
      background: var(--primary-dark);
      box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
      transform: translateY(-1px);
    }

    .btn-clear {
      background: #6b7280;
      color: white;
    }

    .btn-clear:hover {
      background: #4b5563;
      box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
      transform: translateY(-1px);
    }

    /* Info bar */
    .info-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding: 1rem 1.25rem;
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      flex-wrap: wrap;
      gap: 1rem;
    }

    .info-text {
      color: var(--text-primary);
      font-size: 14px;
      font-weight: 600;
    }

    /* Modern table card wrapper */
    .table-card {
      background: var(--bg-card);
      border-radius: var(--radius);
      box-shadow: var(--shadow-md);
      overflow: hidden;
      border: 1px solid var(--border);
      position: relative;
      min-height: 400px;
      display: flex;
      flex-direction: column;
      will-change: contents;
      backface-visibility: hidden;
      transform: translateZ(0);
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

    .users-count {
      background: var(--primary);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
    }

    /* Modern table styling */
    .users-table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    .users-table-wrapper {
      flex: 1;
      overflow-x: auto;
      position: relative;
    }

    .users-table th {
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

    .users-table td {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid var(--border);
      font-size: 14px;
      color: var(--text-primary);
    }

    .users-table tbody tr {
      transition: var(--transition);
    }

    .users-table tbody tr:hover {
      background: var(--bg-main);
    }

    .users-table tbody tr:last-child td {
      border-bottom: none;
    }

    /* Modern role badges */
    .role-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.375rem 0.875rem;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: capitalize;
    }

    .role-admin {
      background: #dbeafe;
      color: #1e40af;
    }

    .role-applicant {
      background: #d1fae5;
      color: #065f46;
    }

    /* Modern action buttons */
    .action-buttons {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .btn-edit {
      background: #ff9800;
      color: white;
      padding: 0.5rem 1rem;
      font-size: 13px;
    }

    .btn-edit:hover {
      background: #f57c00;
      box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
      transform: translateY(-1px);
    }

    .btn-delete {
      background: #f44336;
      color: white;
      padding: 0.5rem 1rem;
      font-size: 13px;
    }

    .btn-delete:hover {
      background: #c62828;
      box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
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
      font-size: 15px;
    }

    /* Pagination */
    .pagination-wrapper {
      margin-top: 1.5rem;
      padding: 1.5rem;
      border-top: 1px solid var(--border);
      display: flex;
      justify-content: center;
    }

    .pagination {
      display: flex;
      list-style: none;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .page-item {
      margin: 0;
    }

    .page-link {
      display: block;
      padding: 0.5rem 0.875rem;
      color: var(--text-primary);
      text-decoration: none;
      border: 1px solid var(--border);
      border-radius: 8px;
      transition: var(--transition);
      background: var(--bg-card);
      font-size: 14px;
      font-weight: 500;
    }

    .page-link:hover {
      background: var(--bg-main);
      border-color: var(--primary);
      color: var(--primary);
    }

    .page-item.active .page-link {
      background: var(--primary);
      color: white;
      border-color: var(--primary);
    }

    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
      font-weight: 600;
    }

    /* Loading state */
    .loading {
      text-align: center;
      padding: 2rem;
      color: var(--text-secondary);
    }

    .loading::after {
      content: "...";
      animation: dots 1.5s steps(4, end) infinite;
    }

    @keyframes dots {
      0%, 20% { content: "."; }
      40% { content: ".."; }
      60%, 100% { content: "..."; }
    }

    #usersTableContainer {
      position: relative;
      width: 100%;
    }

    #usersTableContainer.loading {
      opacity: 0.7;
      pointer-events: none;
    }

    #usersTableContainer.loading .table-card {
      position: relative;
    }

    /* Prevent layout shifts */
    .users-table tbody {
      position: relative;
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

      .search-form {
        flex-direction: column;
      }

      .search-input {
        min-width: 100%;
      }

      .table-card {
        overflow-x: auto;
      }

      .users-table {
        min-width: 700px;
      }

      .users-table th,
      .users-table td {
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

      .search-form {
        gap: 0.75rem;
      }

      .users-table th,
      .users-table td {
        padding: 0.75rem 0.875rem;
        font-size: 12px;
      }

      .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 12px;
      }

      .action-buttons {
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
        <i class="fas fa-users"></i>
        User Management
      </h2>
      <p class="page-subtitle">Manage and monitor all system users</p>
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

    <!-- Search Section -->
    <div class="search-section">
      <form method="GET" action="/admin/users" class="search-form" id="searchForm">
        <input 
          type="text" 
          name="search" 
          id="searchInput"
          class="search-input" 
          placeholder="Search by name or email..." 
          value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >
        <button type="submit" class="btn btn-search" id="searchBtn">
          <i class="fas fa-search"></i>
          Search
        </button>
        <?php if (!empty($search)): ?>
          <a href="/admin/users" class="btn btn-clear" id="clearBtn">
            <i class="fas fa-times"></i>
            Clear
          </a>
        <?php endif; ?>
      </form>
    </div>

    <!-- Info Bar -->
    <div class="info-bar" id="infoBar">
      <span class="info-text" id="totalUsers">
        <i class="fas fa-users"></i>
        Total Users: <?= isset($total_rows) ? number_format($total_rows) : 0 ?>
        <?php if (!empty($search)): ?>
          (Filtered)
        <?php endif; ?>
      </span>
      <span class="info-text" id="paginationInfo">
        <?php if (isset($pagination_data['info'])): ?>
          <?= htmlspecialchars($pagination_data['info'], ENT_QUOTES, 'UTF-8') ?>
        <?php endif; ?>
      </span>
    </div>

    <!-- Table Card -->
    <div id="usersTableContainer">
      <div class="table-card">
        <div class="table-header">
          <h3>
            <i class="fas fa-list"></i>
            All Users
            <span class="users-count"><?= isset($users) ? count($users) : 0 ?></span>
          </h3>
        </div>
        <div class="users-table-wrapper">
          <table class="users-table">
            <thead>
              <tr>
                <th style="width: 80px;">ID</th>
                <th style="width: 200px;">Full Name</th>
                <th style="width: 250px;">Email</th>
                <th style="width: 120px;">Role</th>
                <th style="width: 200px;">Actions</th>
              </tr>
            </thead>
            <tbody id="usersTableBody">
            <?php if (empty($users)): ?>
              <tr>
                <td colspan="5" class="empty-state">
                  <div class="empty-state-icon">
                    <i class="fas fa-user-slash"></i>
                  </div>
                  <h3>No Users Found</h3>
                  <p><?= !empty($search) ? 'No users match your search criteria.' : 'There are no users in the system yet.' ?></p>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= htmlspecialchars($user['id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                  <td><strong><?= htmlspecialchars($user['fullname'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong></td>
                  <td><?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                  <td>
                    <?php
                    $role = strtolower($user['role'] ?? 'applicant');
                    $roleIcon = $role === 'admin' ? 'fa-user-shield' : 'fa-user';
                    ?>
                    <span class="role-badge role-<?= $role ?>">
                      <i class="fas <?= $roleIcon ?>"></i>
                      <?= htmlspecialchars($user['role'] ?? 'applicant', ENT_QUOTES, 'UTF-8') ?>
                    </span>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <a href="/admin/users/edit/<?= $user['id'] ?? '' ?>" class="btn btn-edit">
                        <i class="fas fa-edit"></i>
                        Edit
                      </a>
                      <a href="/admin/users/delete/<?= $user['id'] ?? '' ?>" 
                         class="btn btn-delete" 
                         onclick="return confirm('Are you sure you want to delete this user?')">
                        <i class="fas fa-trash"></i>
                        Delete
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div id="paginationContainer">
          <?php if (isset($pagination) && isset($pagination_data) && $pagination_data['last'] > 1): ?>
            <div class="pagination-wrapper">
              <?= $pagination->paginate() ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
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

    // Search functionality
    (function() {
      const searchForm = document.getElementById('searchForm');
      const searchInput = document.getElementById('searchInput');
      const searchBtn = document.getElementById('searchBtn');
      const usersTableContainer = document.getElementById('usersTableContainer');
      const usersTableBody = document.getElementById('usersTableBody');
      const paginationContainer = document.getElementById('paginationContainer');
      const totalUsers = document.getElementById('totalUsers');
      const paginationInfo = document.getElementById('paginationInfo');
      
      let searchTimeout;

      // Handle form submission
      searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
      });

      // Handle real-time search as user types (with debounce)
      searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
          performSearch();
        }, 500); // Wait 500ms after user stops typing
      });

      // Handle clear button if it exists initially
      const initialClearBtn = document.getElementById('clearBtn');
      if (initialClearBtn) {
        initialClearBtn.addEventListener('click', function(e) {
          e.preventDefault();
          searchInput.value = '';
          performSearch();
        });
      }

      // Function to perform AJAX search
      function performSearch() {
        const searchQuery = searchInput.value.trim();
        const url = '/admin/users/search?search=' + encodeURIComponent(searchQuery) + '&page=1';
        
        // Store current scroll position and table position
        const tableCard = usersTableContainer.querySelector('.table-card');
        const tableRect = tableCard ? tableCard.getBoundingClientRect() : null;
        const currentScrollY = window.scrollY;
        const tableTop = tableRect ? tableRect.top + currentScrollY : 0;
        
        if (tableCard) {
          // Lock the height to prevent any movement
          const currentHeight = tableCard.offsetHeight;
          tableCard.style.height = currentHeight + 'px';
          tableCard.style.overflow = 'hidden';
          
          // Show loading state - preserve table structure
          usersTableContainer.classList.add('loading');
          const loadingRow = '<tr><td colspan="5" class="loading" style="text-align: center; padding: 2rem;">Loading...</td></tr>';
          usersTableBody.innerHTML = loadingRow;
        }
        
        // Make AJAX request
        fetch(url)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Update table content
              updateTable(data);
              updateURL(searchQuery);
              
              // Restore scroll position to maintain table position
              requestAnimationFrame(() => {
                if (tableRect && tableCard) {
                  const newRect = tableCard.getBoundingClientRect();
                  const newTop = newRect.top + window.scrollY;
                  const offset = newTop - tableTop;
                  
                  if (Math.abs(offset) > 1) {
                    window.scrollTo({
                      top: currentScrollY + offset,
                      behavior: 'instant'
                    });
                  }
                }
              });
            } else {
              showError('An error occurred while searching.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            showError('An error occurred while searching. Please try again.');
          })
          .finally(() => {
            usersTableContainer.classList.remove('loading');
            if (tableCard) {
              // Use requestAnimationFrame to smoothly restore height
              requestAnimationFrame(() => {
                tableCard.style.height = '';
                tableCard.style.overflow = '';
              });
            }
          });
      }

      // Function to update table with search results
      function updateTable(data) {
        // Update total users count
        totalUsers.innerHTML = '<i class="fas fa-users"></i> Total Users: ' + data.total_rows.toLocaleString() + 
          (data.search ? ' (Filtered)' : '');
        
        // Update pagination info
        paginationInfo.textContent = data.pagination_info || '';
        
        // Update table header count badge
        const tableHeaderCount = usersTableContainer.querySelector('.table-header .users-count');
        if (tableHeaderCount) {
          tableHeaderCount.textContent = data.users.length;
        }
        
        // Update table body - preserve table structure
        if (data.users.length === 0) {
          usersTableBody.innerHTML = '<tr><td colspan="5" class="empty-state">' +
            '<div class="empty-state-icon"><i class="fas fa-user-slash"></i></div>' +
            '<h3>No Users Found</h3>' +
            '<p>' + (data.search ? 'No users match your search criteria.' : 'There are no users in the system yet.') + '</p>' +
            '</td></tr>';
        } else {
          let html = '';
          data.users.forEach(function(user) {
            const role = (user.role || 'applicant').toLowerCase();
            const roleIcon = role === 'admin' ? 'fa-user-shield' : 'fa-user';
            html += '<tr>' +
              '<td>' + escapeHtml(user.id || '') + '</td>' +
              '<td><strong>' + escapeHtml(user.fullname || '') + '</strong></td>' +
              '<td>' + escapeHtml(user.email || '') + '</td>' +
              '<td><span class="role-badge role-' + role + '">' +
                '<i class="fas ' + roleIcon + '"></i> ' +
                escapeHtml(user.role || 'applicant') + '</span></td>' +
              '<td><div class="action-buttons">' +
                '<a href="/admin/users/edit/' + (user.id || '') + '" class="btn btn-edit">' +
                '<i class="fas fa-edit"></i> Edit</a> ' +
                '<a href="/admin/users/delete/' + (user.id || '') + '" ' +
                'class="btn btn-delete" ' +
                'onclick="return confirm(\'Are you sure you want to delete this user?\')">' +
                '<i class="fas fa-trash"></i> Delete</a>' +
              '</div></td>' +
            '</tr>';
          });
          usersTableBody.innerHTML = html;
        }
        
        // Update pagination - preserve table card structure
        if (data.pagination_html) {
          paginationContainer.innerHTML = '<div class="pagination-wrapper">' + 
            data.pagination_html + '</div>';
          
          // Re-attach pagination click handlers
          attachPaginationHandlers();
        } else {
          paginationContainer.innerHTML = '';
        }
        
        // Update clear button visibility
        updateClearButton(data.search);
      }

      // Function to update URL without reload
      function updateURL(searchQuery) {
        const url = new URL(window.location);
        if (searchQuery) {
          url.searchParams.set('search', searchQuery);
        } else {
          url.searchParams.delete('search');
        }
        window.history.pushState({}, '', url);
      }

      // Function to update clear button visibility
      function updateClearButton(hasSearch) {
        let clearBtn = document.getElementById('clearBtn');
        
        if (hasSearch) {
          if (!clearBtn) {
            const btn = document.createElement('a');
            btn.href = '/admin/users';
            btn.className = 'btn btn-clear';
            btn.id = 'clearBtn';
            btn.innerHTML = '<i class="fas fa-times"></i> Clear';
            btn.addEventListener('click', function(e) {
              e.preventDefault();
              searchInput.value = '';
              performSearch();
            });
            searchForm.appendChild(btn);
          }
        } else {
          if (clearBtn) {
            clearBtn.remove();
          }
        }
      }

      // Function to attach pagination handlers
      function attachPaginationHandlers() {
        const paginationLinks = document.querySelectorAll('#paginationContainer .page-link');
        paginationLinks.forEach(function(link) {
          link.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            if (href) {
              const url = new URL(href, window.location.origin);
              const page = url.searchParams.get('page') || '1';
              const search = searchInput.value.trim();
              
              const searchUrl = '/admin/users/search?search=' + encodeURIComponent(search) + 
                '&page=' + page;
              
              usersTableContainer.classList.add('loading');
              
              fetch(searchUrl)
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    updateTable(data);
                    updateURL(search);
                    usersTableContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                  }
                })
                .catch(error => {
                  console.error('Error:', error);
                  showError('An error occurred while loading the page.');
                })
                .finally(() => {
                  usersTableContainer.classList.remove('loading');
                });
            }
          });
        });
      }

      // Function to escape HTML
      function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // Function to show error
      function showError(message) {
        usersTableBody.innerHTML = '<tr><td colspan="5" class="empty-state">' +
          '<p style="color: #991b1b;">' + escapeHtml(message) + '</p>' +
          '</td></tr>';
      }

      // Handle browser back/forward buttons
      window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const search = urlParams.get('search') || '';
        searchInput.value = search;
        performSearch();
      });
    })();
  </script>

</body>
</html>
