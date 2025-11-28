<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Application - Applicant</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #2e7d32;
      --primary-dark: #1b5e20;
      --primary-light: #4caf50;
      --secondary-color: #558b2f;
      --bg-color: #f8f9fa;
      --card-bg: #ffffff;
      --text-primary: #212529;
      --text-secondary: #6c757d;
      --border-color: #e9ecef;
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
      --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
      --success-bg: #d4edda;
      --success-text: #155724;
      --warning-bg: #fff3cd;
      --warning-text: #856404;
      --danger-bg: #f8d7da;
      --danger-text: #721c24;
      --radius-sm: 6px;
      --radius-md: 10px;
      --radius-lg: 16px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: var(--bg-color);
      color: var(--text-primary);
      min-height: 100vh;
      line-height: 1.6;
    }

    /* Modern header with better navigation */
    header {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      color: white;
      padding: 1.5rem 2rem;
      box-shadow: var(--shadow-md);
      position: sticky;
      top: 0;
      z-index: 100;
      backdrop-filter: blur(10px);
    }

    .header-container {
      max-width: 1400px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 2rem;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(255, 255, 255, 0.15);
      color: white;
      padding: 0.6rem 1.2rem;
      border-radius: var(--radius-sm);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .back-link:hover {
      background: white;
      color: var(--primary-color);
      transform: translateX(-4px);
    }

    header h1 {
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .user-menu {
      position: relative;
    }

    .user-menu-toggle {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      background: rgba(255, 255, 255, 0.15);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 0.7rem 1.2rem;
      border-radius: var(--radius-sm);
      cursor: pointer;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    .user-menu-toggle:hover {
      background: rgba(255, 255, 255, 0.25);
    }

    .user-menu-toggle i {
      transition: transform 0.3s ease;
    }

    .user-menu-toggle.active i {
      transform: rotate(180deg);
    }

    .dropdown-menu {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      background: white;
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-lg);
      min-width: 220px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
    }

    .dropdown-menu.active {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .dropdown-menu a {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.9rem 1.2rem;
      color: var(--text-primary);
      text-decoration: none;
      font-size: 0.95rem;
      transition: all 0.2s ease;
      border-bottom: 1px solid var(--border-color);
    }

    .dropdown-menu a:last-child {
      border-bottom: none;
    }

    .dropdown-menu a:hover {
      background: var(--bg-color);
      color: var(--primary-color);
      padding-left: 1.5rem;
    }

    .dropdown-menu a.logout-item {
      color: #dc3545;
    }

    .dropdown-menu a.logout-item:hover {
      background: var(--danger-bg);
      color: var(--danger-text);
    }

    /* Modern container with better spacing */
    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 2rem;
    }

    .page-header {
      background: white;
      padding: 2rem;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-sm);
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1.5rem;
    }

    .page-title {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .page-title i {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
      border-radius: var(--radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.5rem;
    }

    .page-title h2 {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
    }

    .page-title .app-id {
      font-size: 0.9rem;
      color: var(--text-secondary);
      font-weight: 500;
    }

    /* Enhanced status badges with icons */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.6rem 1.2rem;
      border-radius: 50px;
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: var(--shadow-sm);
    }

    .status-pending {
      background: var(--warning-bg);
      color: var(--warning-text);
    }

    .status-approved {
      background: var(--success-bg);
      color: var(--success-text);
    }

    .status-rejected {
      background: var(--danger-bg);
      color: var(--danger-text);
    }

    /* Card-based section layout */
    .section {
      background: white;
      padding: 2rem;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-sm);
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
    }

    .section:hover {
      box-shadow: var(--shadow-md);
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid var(--border-color);
    }

    .section-header i {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.1rem;
    }

    .section-header h3 {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
    }

    /* Modern grid layout with better styling */
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    .info-item {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .info-label {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 600;
      color: var(--text-secondary);
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .info-label i {
      color: var(--primary-color);
      font-size: 0.9rem;
    }

    .info-value {
      color: var(--text-primary);
      padding: 0.9rem 1rem;
      background: var(--bg-color);
      border-radius: var(--radius-sm);
      border-left: 3px solid var(--primary-color);
      font-size: 0.95rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .info-value:hover {
      background: #e8f5e9;
      border-left-color: var(--primary-dark);
    }

    /* Enhanced essay box */
    .essay-box {
      background: var(--bg-color);
      padding: 1.5rem;
      border-radius: var(--radius-md);
      border-left: 4px solid var(--primary-color);
      white-space: pre-wrap;
      line-height: 1.8;
      font-size: 0.95rem;
      color: var(--text-primary);
      box-shadow: var(--shadow-sm);
    }

    /* Modern footer */
    footer {
      text-align: center;
      padding: 3rem 2rem;
      margin-top: 4rem;
      color: var(--text-secondary);
      font-size: 0.9rem;
      border-top: 1px solid var(--border-color);
      background: white;
    }

    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      background: white;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-sm);
    }

    .empty-state i {
      font-size: 4rem;
      color: var(--text-secondary);
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    .empty-state p {
      color: var(--text-secondary);
      font-size: 1.1rem;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .header-container {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
      }

      .header-left {
        flex-direction: column;
        align-items: stretch;
      }

      header h1 {
        font-size: 1.25rem;
        text-align: center;
      }

      .back-link {
        justify-content: center;
      }

      .container {
        padding: 0 1rem;
        margin: 1rem auto;
      }

      .page-header {
        flex-direction: column;
        align-items: stretch;
        padding: 1.5rem;
      }

      .page-title {
        flex-direction: column;
        text-align: center;
      }

      .status-badge {
        justify-content: center;
      }

      .section {
        padding: 1.5rem;
      }

      .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 0.75rem;
      }

      .page-header h1 {
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
  </style>
</head>
<body>

  <header>
    <div class="header-container">
      <div class="header-left">
        <a href="/applicant/my-applications" class="back-link">
          <i class="fas fa-arrow-left"></i> Back to Applications
        </a>
        <h1>Application Details</h1>
      </div>
      <div class="user-menu">
        <button class="user-menu-toggle" onclick="toggleUserMenu()">
          <i class="fas fa-user-circle"></i>
          <?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'User', ENT_QUOTES, 'UTF-8') ?>
          <i class="fas fa-chevron-down"></i>
        </button>
        <div class="dropdown-menu" id="userDropdown">
          <a href="/apply/form"><i class="fas fa-file-alt"></i> Apply for Application</a>
          <a href="/applicant/my-applications"><i class="fas fa-folder-open"></i> My Applications</a>
          <a href="/applicant/profile"><i class="fas fa-user"></i> Profile</a>
          <a href="/logout" class="logout-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <?php if (empty($application)): ?>
      <div class="empty-state">
        <i class="fas fa-file-circle-xmark"></i>
        <p>Application not found.</p>
      </div>
    <?php else: ?>
      <div class="page-header">
        <div class="page-title">
          <i class="fas fa-file-alt"></i>
          <div>
            <h2>Application Details</h2>
          </div>
        </div>
        <span class="status-badge status-<?= strtolower($application['status'] ?? 'pending') ?>">
          <i class="fas fa-<?= ($application['status'] ?? 'pending') === 'Approved' ? 'check-circle' : (($application['status'] ?? 'pending') === 'Rejected' ? 'times-circle' : 'clock') ?>"></i>
          <?= htmlspecialchars($application['status'] ?? 'Pending', ENT_QUOTES, 'UTF-8') ?>
        </span>
      </div>

      <div class="section">
        <div class="section-header">
          <i class="fas fa-user"></i>
          <h3>Personal Information</h3>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label"><i class="fas fa-signature"></i> Last Name</span>
            <span class="info-value"><?= htmlspecialchars($application['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-signature"></i> First Name</span>
            <span class="info-value"><?= htmlspecialchars($application['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-signature"></i> Middle Name</span>
            <span class="info-value"><?= htmlspecialchars($application['middle_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
            <span class="info-value"><?= htmlspecialchars($application['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-phone"></i> Contact Number</span>
            <span class="info-value"><?= htmlspecialchars($application['contact_no'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-calendar"></i> Birthday</span>
            <span class="info-value"><?= isset($application['birthday']) ? date('M d, Y', strtotime($application['birthday'])) : 'N/A' ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-hashtag"></i> Age</span>
            <span class="info-value"><?= htmlspecialchars($application['age'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-heart"></i> Civil Status</span>
            <span class="info-value"><?= htmlspecialchars($application['civil_status'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
        <div class="info-item" style="margin-top: 1.5rem;">
          <span class="info-label"><i class="fas fa-map-marker-alt"></i> Address</span>
          <span class="info-value"><?= htmlspecialchars($application['address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <i class="fas fa-graduation-cap"></i>
          <h3>Educational Background</h3>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label"><i class="fas fa-school"></i> School/University</span>
            <span class="info-value"><?= htmlspecialchars($application['school_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-layer-group"></i> Year Level</span>
            <span class="info-value"><?= htmlspecialchars($application['year_level'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-building"></i> School Type</span>
            <span class="info-value"><?= htmlspecialchars($application['school_type'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-book"></i> Course/Major</span>
            <span class="info-value"><?= htmlspecialchars($application['course'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <i class="fas fa-pen-fancy"></i>
          <h3>Essay</h3>
        </div>
        <div class="essay-box"><?= htmlspecialchars($application['essay'] ?? 'No essay provided.', ENT_QUOTES, 'UTF-8') ?></div>
      </div>

      <div class="section">
        <div class="section-header">
          <i class="fas fa-users"></i>
          <h3>Family Background</h3>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label"><i class="fas fa-male"></i> Father's Name</span>
            <span class="info-value"><?= htmlspecialchars($application['father_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-briefcase"></i> Father's Occupation</span>
            <span class="info-value"><?= htmlspecialchars($application['father_occupation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-female"></i> Mother's Name</span>
            <span class="info-value"><?= htmlspecialchars($application['mother_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-briefcase"></i> Mother's Occupation</span>
            <span class="info-value"><?= htmlspecialchars($application['mother_occupation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-money-bill-wave"></i> Annual Income</span>
            <span class="info-value"><?= htmlspecialchars($application['annual_income'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <i class="fas fa-info-circle"></i>
          <h3>Application Details</h3>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label"><i class="fas fa-calendar-check"></i> Date Submitted</span>
            <span class="info-value"><?= isset($application['date_submitted']) ? date('M d, Y h:i A', strtotime($application['date_submitted'])) : 'N/A' ?></span>
          </div>
          <div class="info-item">
            <span class="info-label"><i class="fas fa-handshake"></i> Service Obligation</span>
            <span class="info-value"><?= htmlspecialchars($application['service_obligation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <footer>
    <i class="fas fa-heart" style="color: #e74c3c;"></i>
    &copy; <?= date('Y') ?> Municipality of Naujan | Educational Assistance Program
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
