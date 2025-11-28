<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile - Applicant</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Added FontAwesome for icons and updated to modern Inter font -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Updated CSS variables and modern design system */
    :root {
      --primary-green: #2e7d32;
      --primary-green-dark: #1b5e20;
      --primary-green-light: #4caf50;
      --bg-gradient-start: #f5f7fa;
      --bg-gradient-end: #e8f5e9;
      --card-bg: #ffffff;
      --text-primary: #1a1a1a;
      --text-secondary: #666666;
      --text-muted: #999999;
      --border-color: #e0e0e0;
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
      --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 16px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: #f3f4f6;
      min-height: 100vh;
      color: var(--text-primary);
      line-height: 1.6;
      display: flex;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 260px;
      background-color: #ffffff;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      border-right: 1px solid var(--border-color);
      display: flex;
      flex-direction: column;
      z-index: 50;
      transition: transform 0.3s ease;
    }

    .sidebar-brand {
      height: 70px;
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      border-bottom: 1px solid var(--border-color);
    }

    .sidebar-brand h2 {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--primary-green);
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
      color: var(--primary-green);
    }

    .nav-item i {
      width: 24px;
      margin-right: 12px;
    }

    .sidebar-footer {
      padding: 1.5rem;
      border-top: 1px solid var(--border-color);
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
      color: var(--primary-green);
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
      margin-left: 260px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Header */
    header {
      height: 70px;
      background-color: #ffffff;
      border-bottom: 1px solid var(--border-color);
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
      border: 1px solid var(--border-color);
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

    /* Modern container with better spacing */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 32px 24px;
      flex: 1;
      width: 100%;
    }

    .page-header {
      margin-bottom: 32px;
    }

    .page-header h2 {
      font-size: 28px;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .page-header h2 i {
      color: var(--primary-green);
    }

    .page-header p {
      color: var(--text-secondary);
      font-size: 15px;
    }

    /* Enhanced alert system with icons */
    .alert {
      padding: 16px 20px;
      border-radius: var(--radius-md);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      font-weight: 500;
      animation: slideIn 0.3s ease;
      box-shadow: var(--shadow-sm);
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
      background: #e8f5e9;
      border: 1px solid #c8e6c9;
      color: #2e7d32;
    }

    .alert-success i {
      color: #4caf50;
    }

    .alert-error {
      background: #ffebee;
      border: 1px solid #ffcdd2;
      color: #c62828;
    }

    .alert-error i {
      color: #f44336;
    }

    /* Card-based section design */
    .profile-card {
      background: var(--card-bg);
      border-radius: var(--radius-lg);
      padding: 28px;
      margin-bottom: 24px;
      box-shadow: var(--shadow-md);
      border: 1px solid var(--border-color);
      transition: all 0.3s ease;
    }

    .profile-card:hover {
      box-shadow: var(--shadow-lg);
      transform: translateY(-2px);
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
      padding-bottom: 16px;
      border-bottom: 2px solid var(--bg-gradient-end);
    }

    .section-icon {
      width: 42px;
      height: 42px;
      background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 18px;
    }

    .section-header h3 {
      font-size: 20px;
      font-weight: 700;
      color: var(--text-primary);
      flex: 1;
    }

    /* Improved info grid with better visual hierarchy */
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 24px;
    }

    .info-item {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .info-label {
      font-weight: 600;
      color: var(--text-secondary);
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .info-label i {
      color: var(--primary-green);
      font-size: 14px;
    }

    .info-value {
      color: var(--text-primary);
      font-size: 15px;
      font-weight: 500;
      padding: 8px 0;
    }

    /* Modern form styling with better inputs */
    .form-group {
      margin-bottom: 24px;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid var(--border-color);
      border-radius: var(--radius-sm);
      font-size: 14px;
      font-family: inherit;
      transition: all 0.2s ease;
      background: var(--card-bg);
      color: var(--text-primary);
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      outline: none;
      border-color: var(--primary-green);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    .form-row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .form-group small {
      display: block;
      margin-top: 6px;
      color: var(--text-secondary);
      font-size: 12px;
    }

    /* Enhanced button styling */
    .btn-group {
      display: flex;
      gap: 12px;
      margin-top: 32px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 12px 28px;
      border: none;
      border-radius: var(--radius-sm);
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
      font-family: inherit;
    }

    .btn i {
      font-size: 16px;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
      color: white;
      box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .btn-secondary {
      background: var(--card-bg);
      color: var(--text-primary);
      border: 1.5px solid var(--border-color);
    }

    .btn-secondary:hover {
      background: var(--bg-gradient-end);
      border-color: var(--primary-green);
      color: var(--primary-green);
    }

    /* Mode toggle styling */
    .edit-mode,
    .view-mode {
      display: none;
    }

    .edit-mode.active,
    .view-mode.active {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    footer {
      text-align: center;
      padding: 32px 24px;
      color: var(--text-secondary);
      font-size: 14px;
      border-top: 1px solid var(--border-color);
      background: var(--card-bg);
      margin-top: 48px;
    }

    /* Mobile responsiveness */
    @media (max-width: 1024px) {
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
      .container {
        padding: 20px 16px;
      }

      .page-title {
        font-size: 22px;
      }

      .profile-card {
        padding: 20px;
      }

      .page-header h2 {
        font-size: 24px;
      }

      .form-row,
      .info-grid {
        grid-template-columns: 1fr;
      }

      .btn-group {
        flex-direction: column;
      }

      .btn {
        width: 100%;
        justify-content: center;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 16px 12px;
      }

      .page-title {
        font-size: 20px;
      }

      .profile-card {
        padding: 16px;
      }

      .page-header h2 {
        font-size: 20px;
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
            <a href="/applicant/my-applications" class="nav-item">
                <i class="fas fa-folder-open"></i> My Applications
            </a>
            <a href="/applicant/profile" class="nav-item active">
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
                <h1 style="display:inline-block; margin-left: 10px;">My Profile</h1>
            </div>
            
            <div class="header-actions">
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>

        <div class="container">
    <!-- Enhanced alerts with icons -->
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

    <?php if (empty($user)): ?>
      <div class="profile-card">
        <p style="text-align: center; color: var(--text-secondary);">User not found.</p>
      </div>
    <?php else: ?>
      <!-- Modern view mode with card-based sections -->
      <div class="view-mode active" id="viewMode">
        <div class="profile-card">
          <div class="section-header">
            <div class="section-icon">
              <i class="fas fa-user"></i>
            </div>
            <h3>Personal Information</h3>
          </div>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-user"></i>
                Last Name
              </span>
              <span class="info-value"><?= htmlspecialchars($user['last_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-user"></i>
                First Name
              </span>
              <span class="info-value"><?= htmlspecialchars($user['first_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-user"></i>
                Middle Name
              </span>
              <span class="info-value"><?= htmlspecialchars($user['middle_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
              <span class="info-label">
                <i class="fas fa-home"></i>
                Home Address
              </span>
              <span class="info-value"><?= htmlspecialchars($user['address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-calendar"></i>
                Birthday
              </span>
              <span class="info-value"><?= isset($user['birthday']) && $user['birthday'] ? date('M d, Y', strtotime($user['birthday'])) : 'N/A' ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-hashtag"></i>
                Age
              </span>
              <span class="info-value"><?= htmlspecialchars($user['age'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-heart"></i>
                Civil Status
              </span>
              <span class="info-value"><?= htmlspecialchars($user['civil_status'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-phone"></i>
                Contact No.
              </span>
              <span class="info-value"><?= htmlspecialchars($user['contact_no'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-map-marker-alt"></i>
                Place of Birth
              </span>
              <span class="info-value"><?= htmlspecialchars($user['birth_place'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-ruler-vertical"></i>
                Height (cm)
              </span>
              <span class="info-value"><?= htmlspecialchars($user['height'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-weight"></i>
                Weight (kg)
              </span>
              <span class="info-value"><?= htmlspecialchars($user['weight'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-envelope"></i>
                Email Address
              </span>
              <span class="info-value"><?= htmlspecialchars($user['email'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
              <span class="info-label">
                <i class="fas fa-star"></i>
                Special Skills
              </span>
              <span class="info-value"><?= htmlspecialchars($user['special_skills'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
        </div>

        <div class="profile-card">
          <div class="section-header">
            <div class="section-icon">
              <i class="fas fa-graduation-cap"></i>
            </div>
            <h3>Educational Background</h3>
          </div>
          <div class="info-grid">
            <div class="info-item" style="grid-column: 1 / -1;">
              <span class="info-label">
                <i class="fas fa-school"></i>
                School / College / University
              </span>
              <span class="info-value"><?= htmlspecialchars($user['school_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-layer-group"></i>
                Year Level
              </span>
              <span class="info-value"><?= htmlspecialchars($user['year_level'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-building"></i>
                School Type
              </span>
              <span class="info-value"><?= htmlspecialchars($user['school_type'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-book"></i>
                Course / Major
              </span>
              <span class="info-value"><?= htmlspecialchars($user['course'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-chart-line"></i>
                Academic Standing
              </span>
              <span class="info-value"><?= htmlspecialchars($user['academic_standing'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
        </div>

        <div class="profile-card">
          <div class="section-header">
            <div class="section-icon">
              <i class="fas fa-users"></i>
            </div>
            <h3>Family Background</h3>
          </div>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-male"></i>
                Father's Name
              </span>
              <span class="info-value"><?= htmlspecialchars($user['father_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-briefcase"></i>
                Father's Occupation
              </span>
              <span class="info-value"><?= htmlspecialchars($user['father_occupation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-female"></i>
                Mother's Name
              </span>
              <span class="info-value"><?= htmlspecialchars($user['mother_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-briefcase"></i>
                Mother's Occupation
              </span>
              <span class="info-value"><?= htmlspecialchars($user['mother_occupation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-phone"></i>
                Parent Contact
              </span>
              <span class="info-value"><?= htmlspecialchars($user['parent_contact'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-home"></i>
                Parent Address
              </span>
              <span class="info-value"><?= htmlspecialchars($user['parent_address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
              <span class="info-label">
                <i class="fas fa-dollar-sign"></i>
                Household Annual Income
              </span>
              <span class="info-value"><?= htmlspecialchars($user['annual_income'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
        </div>

        <div class="profile-card">
          <div class="section-header">
            <div class="section-icon">
              <i class="fas fa-user-shield"></i>
            </div>
            <h3>Guardian Information</h3>
          </div>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-user"></i>
                Guardian Name
              </span>
              <span class="info-value"><?= htmlspecialchars($user['guardian_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-link"></i>
                Relationship
              </span>
              <span class="info-value"><?= htmlspecialchars($user['guardian_relationship'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-phone"></i>
                Guardian Contact
              </span>
              <span class="info-value"><?= htmlspecialchars($user['guardian_contact'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">
                <i class="fas fa-home"></i>
                Guardian Address
              </span>
              <span class="info-value"><?= htmlspecialchars($user['guardian_address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" onclick="toggleEdit()">
            <i class="fas fa-edit"></i>
            Edit Profile
          </button>
        </div>
      </div>

      <!-- Modern edit mode with enhanced form styling -->
      <div class="edit-mode" id="editMode">
        <form method="POST" action="/applicant/profile/update" onsubmit="return validateForm()">
          <div class="profile-card">
            <div class="section-header">
              <div class="section-icon">
                <i class="fas fa-user"></i>
              </div>
              <h3>Personal Information</h3>
            </div>
            
            <div class="form-row">
              <div class="form-group">
                <label for="last_name">Last Name *</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
              <div class="form-group">
                <label for="first_name">First Name *</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
              <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" id="middle_name" name="middle_name" value="<?= htmlspecialchars($user['middle_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="address">Home Address *</label>
              <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="House No., Street, Barangay, Municipality, Province" required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="birthday">Birthday *</label>
                <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($user['birthday'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
              <div class="form-group">
                <label for="age">Age *</label>
                <input type="number" id="age" name="age" value="<?= htmlspecialchars($user['age'] ?? '', ENT_QUOTES, 'UTF-8') ?>" min="1" required>
              </div>
              <div class="form-group">
                <label for="civil_status">Civil Status</label>
                <input type="text" id="civil_status" name="civil_status" value="<?= htmlspecialchars($user['civil_status'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., Single, Married">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="contact_no">Contact No. *</label>
                <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($user['contact_no'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
              <div class="form-group">
                <label for="birth_place">Place of Birth</label>
                <input type="text" id="birth_place" name="birth_place" value="<?= htmlspecialchars($user['birth_place'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="height">Height (cm)</label>
                <input type="text" id="height" name="height" value="<?= htmlspecialchars($user['height'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
              <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input type="text" id="weight" name="weight" value="<?= htmlspecialchars($user['weight'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="email">Email Address *</label>
              <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="form-group">
              <label for="special_skills">Special Skills</label>
              <textarea id="special_skills" name="special_skills" placeholder="List your special skills"><?= htmlspecialchars($user['special_skills'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
          </div>

          <div class="profile-card">
            <div class="section-header">
              <div class="section-icon">
                <i class="fas fa-graduation-cap"></i>
              </div>
              <h3>Educational Background</h3>
            </div>

            <div class="form-group">
              <label for="school_name">Current School / College / University</label>
              <input type="text" id="school_name" name="school_name" value="<?= htmlspecialchars($user['school_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="year_level">Year Level</label>
                <input type="text" id="year_level" name="year_level" value="<?= htmlspecialchars($user['year_level'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
              <div class="form-group">
                <label for="school_type">School Type</label>
                <select id="school_type" name="school_type">
                  <option value="">-- Select --</option>
                  <option value="Public" <?= (isset($user['school_type']) && $user['school_type'] === 'Public') ? 'selected' : '' ?>>Public</option>
                  <option value="Private" <?= (isset($user['school_type']) && $user['school_type'] === 'Private') ? 'selected' : '' ?>>Private</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="course">Course / Major</label>
              <input type="text" id="course" name="course" value="<?= htmlspecialchars($user['course'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
              <label for="academic_standing">Academic Standing</label>
              <input type="text" id="academic_standing" name="academic_standing" value="<?= htmlspecialchars($user['academic_standing'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="profile-card">
            <div class="section-header">
              <div class="section-icon">
                <i class="fas fa-users"></i>
              </div>
              <h3>Family Background</h3>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="father_name">Father's Name</label>
                <input type="text" id="father_name" name="father_name" value="<?= htmlspecialchars($user['father_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
              <div class="form-group">
                <label for="father_occupation">Father's Occupation</label>
                <input type="text" id="father_occupation" name="father_occupation" value="<?= htmlspecialchars($user['father_occupation'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="mother_name">Mother's Name</label>
                <input type="text" id="mother_name" name="mother_name" value="<?= htmlspecialchars($user['mother_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
              <div class="form-group">
                <label for="mother_occupation">Mother's Occupation</label>
                <input type="text" id="mother_occupation" name="mother_occupation" value="<?= htmlspecialchars($user['mother_occupation'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="parent_contact">Parent Contact Number/s</label>
              <input type="text" id="parent_contact" name="parent_contact" value="<?= htmlspecialchars($user['parent_contact'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
              <label for="parent_address">Parent Address</label>
              <input type="text" id="parent_address" name="parent_address" value="<?= htmlspecialchars($user['parent_address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
              <label for="annual_income">Household Annual Income</label>
              <input type="text" id="annual_income" name="annual_income" value="<?= htmlspecialchars($user['annual_income'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="profile-card">
            <div class="section-header">
              <div class="section-icon">
                <i class="fas fa-user-shield"></i>
              </div>
              <h3>Guardian Information</h3>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="guardian_name">Guardian Name</label>
                <input type="text" id="guardian_name" name="guardian_name" value="<?= htmlspecialchars($user['guardian_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
              <div class="form-group">
                <label for="guardian_relationship">Relationship</label>
                <input type="text" id="guardian_relationship" name="guardian_relationship" value="<?= htmlspecialchars($user['guardian_relationship'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="guardian_contact">Guardian Contact No.</label>
              <input type="text" id="guardian_contact" name="guardian_contact" value="<?= htmlspecialchars($user['guardian_contact'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
              <label for="guardian_address">Guardian Address</label>
              <input type="text" id="guardian_address" name="guardian_address" value="<?= htmlspecialchars($user['guardian_address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="btn-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i>
              Save Changes
            </button>
            <button type="button" class="btn btn-secondary" onclick="toggleEdit()">
              <i class="fas fa-times"></i>
              Cancel
            </button>
          </div>
        </form>
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

        function toggleEdit() {
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            
            if (viewMode.classList.contains('active')) {
                viewMode.classList.remove('active');
                editMode.classList.add('active');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                viewMode.classList.add('active');
                editMode.classList.remove('active');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function validateForm() {
            return true;
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
