<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User - Admin</title>
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
      max-width: 800px;
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

    .alert-error {
      background: #fef2f2;
      border-color: #fca5a5;
      color: #991b1b;
    }

    /* Modern form card */
    .form-card {
      background: var(--bg-card);
      border-radius: var(--radius);
      box-shadow: var(--shadow-md);
      border: 1px solid var(--border);
      padding: 2rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: var(--text-primary);
      font-weight: 600;
      font-size: 14px;
    }

    .required {
      color: #dc2626;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 2px solid var(--border);
      border-radius: 8px;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      transition: var(--transition);
      background: var(--bg-card);
      color: var(--text-primary);
    }

    input:focus, select:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
    }

    .help-text {
      font-size: 12px;
      color: var(--text-secondary);
      margin-top: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .help-text i {
      font-size: 14px;
    }

    /* Button group */
    .btn-group {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--border);
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
      flex: 1;
      justify-content: center;
    }

    .btn-primary {
      background: var(--primary);
      color: white;
    }

    .btn-primary:hover {
      background: var(--primary-dark);
      box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
      transform: translateY(-1px);
    }

    .btn-secondary {
      background: #6b7280;
      color: white;
    }

    .btn-secondary:hover {
      background: #4b5563;
      box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
      transform: translateY(-1px);
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

      .form-card {
        padding: 1.5rem;
      }

      .btn-group {
        flex-direction: column;
      }

      .btn {
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

      .form-card {
        padding: 1.25rem;
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
        <a href="/admin/users" class="back-link">
          <i class="fas fa-arrow-left"></i>
          <span>Back to Users</span>
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
        <i class="fas fa-user-edit"></i>
        Edit User
      </h2>
      <p class="page-subtitle">Update user information and permissions</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></span>
      </div>
    <?php endif; ?>

    <?php if (!empty($user)): ?>
      <div class="form-card">
        <form method="POST" action="/admin/users/update/<?= htmlspecialchars($user['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          <div class="form-group">
            <label for="fullname">
              Full Name <span class="required">*</span>
            </label>
            <input 
              type="text" 
              id="fullname" 
              name="fullname" 
              value="<?= htmlspecialchars($user['fullname'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
              required
              placeholder="Enter full name"
            >
          </div>

          <div class="form-group">
            <label for="email">
              Email Address <span class="required">*</span>
            </label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
              required
              placeholder="Enter email address"
            >
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              placeholder="Enter new password"
            >
            <span class="help-text">
              <i class="fas fa-info-circle"></i>
              Leave blank to keep the current password
            </span>
          </div>

          <div class="form-group">
            <label for="role">
              Role <span class="required">*</span>
            </label>
            <select id="role" name="role" required>
              <option value="applicant" <?= (isset($user['role']) && $user['role'] === 'applicant') ? 'selected' : '' ?>>Applicant</option>
              <option value="admin" <?= (isset($user['role']) && $user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
          </div>

          <div class="btn-group">
            <a href="/admin/users" class="btn btn-secondary">
              <i class="fas fa-times"></i>
              Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i>
              Update User
            </button>
          </div>
        </form>
      </div>
    <?php else: ?>
      <div class="form-card">
        <p style="color: var(--text-secondary); text-align: center; padding: 2rem;">
          <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #f59e0b; margin-bottom: 1rem; display: block;"></i>
          User not found.
        </p>
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
