<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<?php 
// Ensure formData is set, default to empty array if not provided
if (!isset($formData)) {
    $formData = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NEAP Scholarship Application Form</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #16a34a;
      --primary-dark: #15803d;
      --primary-light: #22c55e;
      --secondary: #0ea5e9;
      --background: #f8fafc;
      --surface: #ffffff;
      --border: #e2e8f0;
      --text-primary: #0f172a;
      --text-secondary: #64748b;
      --text-muted: #94a3b8;
      --success: #22c55e;
      --error: #ef4444;
      --warning: #f59e0b;
      --radius: 12px;
      --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
      --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
      --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--background);
      color: var(--text-primary);
      line-height: 1.6;
      min-height: 100vh;
    }

    /* Header */
    .header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 1.5rem 0;
      box-shadow: var(--shadow-lg);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .header-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-title {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .header-title h1 {
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: -0.025em;
    }

    .header-title p {
      font-size: 0.875rem;
      opacity: 0.9;
      font-weight: 400;
    }

    .user-menu {
      position: relative;
    }

    .user-menu-toggle {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 0.625rem 1rem;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.875rem;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .user-menu-toggle:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: translateY(-1px);
    }

    .user-menu-toggle::after {
      content: '▼';
      font-size: 0.625rem;
      transition: transform 0.3s ease;
    }

    .user-menu-toggle.active::after {
      transform: rotate(180deg);
    }

    .dropdown-menu {
      position: absolute;
      top: calc(100% + 0.5rem);
      right: 0;
      background: white;
      border-radius: var(--radius);
      box-shadow: var(--shadow-lg);
      min-width: 200px;
      display: none;
      overflow: hidden;
      border: 1px solid var(--border);
    }

    .dropdown-menu.active {
      display: block;
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

    .dropdown-menu a {
      display: block;
      padding: 0.75rem 1rem;
      color: var(--text-primary);
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s ease;
      border-bottom: 1px solid var(--border);
    }

    .dropdown-menu a:last-child {
      border-bottom: none;
    }

    .dropdown-menu a:hover {
      background: var(--background);
      color: var(--primary);
      padding-left: 1.25rem;
    }

    .dropdown-menu a.logout-item {
      color: var(--error);
    }

    .dropdown-menu a.logout-item:hover {
      background: #fef2f2;
    }

    /* Alert */
    .alert {
      max-width: 1200px;
      margin: 1.5rem auto;
      padding: 1rem 1.5rem;
      border-radius: var(--radius);
      font-size: 0.875rem;
      border: 1px solid transparent;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-error {
      background: #fef2f2;
      border-color: #fecaca;
      color: #991b1b;
    }

    .alert-error::before {
      content: '⚠';
      font-size: 1.25rem;
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1.5rem;
    }

    /* Progress Bar */
    .progress-container {
      background: var(--surface);
      border-radius: var(--radius);
      padding: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border);
    }

    .progress-label {
      font-size: 0.875rem;
      color: var(--text-secondary);
      margin-bottom: 0.5rem;
      font-weight: 500;
    }

    .progress-bar {
      width: 100%;
      height: 8px;
      background: var(--border);
      border-radius: 100px;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
      transition: width 0.3s ease;
      border-radius: 100px;
    }

    /* Form */
    .form-wrapper {
      background: var(--surface);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      border: 1px solid var(--border);
      overflow: hidden;
    }

    .form-section {
      padding: 2rem;
      border-bottom: 1px solid var(--border);
    }

    .form-section:last-child {
      border-bottom: none;
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid var(--primary);
    }

    .section-icon {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, var(--primary), var(--primary-light));
      color: white;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      font-weight: 700;
    }

    .section-header h2 {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: -0.025em;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    .form-grid-2 {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }

    .form-grid-3 {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }

    @media (max-width: 768px) {
      .form-grid-2,
      .form-grid-3 {
        grid-template-columns: 1fr;
      }
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .form-group.full-width {
      grid-column: 1 / -1;
    }

    label {
      font-weight: 600;
      font-size: 0.875rem;
      color: var(--text-primary);
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }

    label .required {
      color: var(--error);
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1.5px solid var(--border);
      border-radius: 8px;
      font-size: 0.9375rem;
      color: var(--text-primary);
      background: var(--surface);
      transition: all 0.2s ease;
      font-family: inherit;
    }

    input:focus,
    select:focus,
    textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }

    input::placeholder,
    textarea::placeholder {
      color: var(--text-muted);
    }

    textarea {
      resize: vertical;
      min-height: 120px;
      line-height: 1.6;
    }

    .file-input-wrapper {
      position: relative;
    }

    input[type="file"] {
      cursor: pointer;
    }

    input[type="file"]::file-selector-button {
      background: var(--primary);
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.875rem;
      margin-right: 0.75rem;
      transition: background 0.2s ease;
    }

    input[type="file"]::file-selector-button:hover {
      background: var(--primary-dark);
    }

    .file-hint {
      font-size: 0.75rem;
      color: var(--text-muted);
      margin-top: 0.25rem;
    }

    /* Declaration Box */
    .declaration-box {
      background: var(--background);
      border: 1.5px solid var(--border);
      border-radius: 8px;
      padding: 1.25rem;
      margin-bottom: 1.5rem;
      line-height: 1.8;
    }

    .declaration-box p {
      font-size: 0.9375rem;
      color: var(--text-secondary);
      text-align: justify;
    }

    /* Buttons */
    .form-actions {
      display: flex;
      gap: 1rem;
      padding: 2rem;
      background: var(--background);
      border-top: 1px solid var(--border);
    }

    .btn {
      padding: 0.875rem 2rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      font-family: inherit;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      flex: 1;
      justify-content: center;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(22, 163, 74, 0.3);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .btn-secondary {
      background: transparent;
      color: var(--text-secondary);
      border: 1.5px solid var(--border);
    }

    .btn-secondary:hover {
      background: var(--background);
      border-color: var(--text-secondary);
      color: var(--text-primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .header-title h1 {
        font-size: 1.125rem;
      }

      .header-title p {
        font-size: 0.75rem;
      }

      .user-menu-toggle {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
      }

      .container {
        padding: 0 1rem;
        margin: 1rem auto;
      }

      .form-section {
        padding: 1.5rem;
      }

      .section-header {
        flex-direction: row;
      }

      .section-header h2 {
        font-size: 1.125rem;
      }

      .form-actions {
        flex-direction: column;
        padding: 1.5rem;
      }

      .btn {
        width: 100%;
        justify-content: center;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 0 0.75rem;
        margin: 0.75rem auto;
      }

      .form-section {
        padding: 1.25rem;
      }

      .section-header h2 {
        font-size: 1rem;
      }

      .form-group label {
        font-size: 13px;
      }

      .form-control {
        font-size: 14px;
        padding: 0.75rem;
      }
    }

    /* Loading State */
    .btn-primary:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }

    .btn-primary:disabled:hover {
      transform: none;
      box-shadow: none;
    }
  </style>
</head>
<body>

  <!-- Modern header with improved typography and layout -->
  <header class="header">
    <div class="header-content">
      <div class="header-title">
        <h1>NEAP Scholarship Application</h1>
        <p>Naujan Educational Assistance Program</p>
      </div>
      <div class="user-menu">
        <button class="user-menu-toggle" onclick="toggleUserMenu()">
          <?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'User', ENT_QUOTES, 'UTF-8') ?>
        </button>
        <div class="dropdown-menu" id="userDropdown">
          <a href="/applicant/dashboard">Dashboard</a>
          <a href="/applicant/my-applications">My Applications</a>
          <a href="/applicant/profile">Profile</a>
          <a href="/logout" class="logout-item">Logout</a>
        </div>
      </div>
    </div>
  </header>

  <?php if (!empty($_SESSION['error_message'])): ?>
  <!-- Improved alert styling with animation -->
  <div class="alert alert-error">
    <?= htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8'); ?>
  </div>
  <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>

  <div class="container">
    <!-- Added progress indicator -->
    <div class="progress-container">
      <div class="progress-label">Application Progress</div>
      <div class="progress-bar">
        <div class="progress-fill" id="progressFill" style="width: 0%"></div>
      </div>
    </div>

    <form action="/apply/submit" method="POST" enctype="multipart/form-data" id="applicationForm">
      <div class="form-wrapper">
        
        <!-- Section 1: Personal Information with modern card layout -->
        <div class="form-section" data-section="1">
          <div class="section-header">
            <div class="section-icon">1</div>
            <h2>Personal Information</h2>
          </div>

          <div class="form-grid-3">
            <div class="form-group">
              <label>Last Name <span class="required">*</span></label>
              <input type="text" name="last_name" value="<?= htmlspecialchars($formData['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="form-group">
              <label>Given Name <span class="required">*</span></label>
              <input type="text" name="first_name" value="<?= htmlspecialchars($formData['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="form-group">
              <label>Middle Name</label>
              <input type="text" name="middle_name" value="<?= htmlspecialchars($formData['middle_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="form-grid" style="margin-top: 1.5rem;">
            <div class="form-group full-width">
              <label>Home Address <span class="required">*</span></label>
              <input type="text" name="address" value="<?= htmlspecialchars($formData['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="House No., Street, Barangay, Municipality, Province" required>
            </div>
          </div>

          <div class="form-grid-3" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Birthday <span class="required">*</span></label>
              <input type="date" name="birthday" value="<?= htmlspecialchars($formData['birthday'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="form-group">
              <label>Age <span class="required">*</span></label>
              <input type="number" name="age" value="<?= htmlspecialchars($formData['age'] ?? '', ENT_QUOTES, 'UTF-8') ?>" min="1" required>
            </div>
            <div class="form-group">
              <label>Civil Status</label>
              <input type="text" name="civil_status" value="<?= htmlspecialchars($formData['civil_status'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="form-grid-2" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Contact No. <span class="required">*</span></label>
              <input type="text" name="contact_no" value="<?= htmlspecialchars($formData['contact_no'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="form-group">
              <label>Place of Birth</label>
              <input type="text" name="birth_place" value="<?= htmlspecialchars($formData['birth_place'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="form-grid-3" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Height (cm)</label>
              <input type="text" name="height" value="<?= htmlspecialchars($formData['height'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="form-group">
              <label>Weight (kg)</label>
              <input type="text" name="weight" value="<?= htmlspecialchars($formData['weight'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="form-group">
              <label>Email Address <span class="required">*</span></label>
              <input type="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
          </div>

          <div class="form-grid" style="margin-top: 1.5rem;">
            <div class="form-group full-width">
              <label>Special Skills</label>
              <input type="text" name="special_skills" value="<?= htmlspecialchars($formData['special_skills'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., Programming, Design, Public Speaking">
            </div>
          </div>
        </div>

        <!-- Section 2: Educational Background -->
        <div class="form-section" data-section="2">
          <div class="section-header">
            <div class="section-icon">2</div>
            <h2>Educational Background</h2>
          </div>

          <div class="form-grid">
            <div class="form-group full-width">
              <label>Current School / College / University <span class="required">*</span></label>
              <input type="text" name="school_name" value="<?= htmlspecialchars($formData['school_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
          </div>

          <div class="form-grid-2" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Year Level <span class="required">*</span></label>
              <select name="year_level" required>
                <option value="">-- Select Year Level --</option>
                <option value="1st Year" <?= (isset($formData['year_level']) && $formData['year_level'] === '1st Year') ? 'selected' : '' ?>>1st Year</option>
                <option value="2nd Year" <?= (isset($formData['year_level']) && $formData['year_level'] === '2nd Year') ? 'selected' : '' ?>>2nd Year</option>
                <option value="3rd Year" <?= (isset($formData['year_level']) && $formData['year_level'] === '3rd Year') ? 'selected' : '' ?>>3rd Year</option>
                <option value="4th Year" <?= (isset($formData['year_level']) && $formData['year_level'] === '4th Year') ? 'selected' : '' ?>>4th Year</option>
                <option value="5th Year" <?= (isset($formData['year_level']) && $formData['year_level'] === '5th Year') ? 'selected' : '' ?>>5th Year</option>
              </select>
            </div>
            <div class="form-group">
              <label>School Type</label>
              <select name="school_type">
                <option value="">-- Select --</option>
                <option value="Public" <?= (isset($formData['school_type']) && $formData['school_type'] === 'Public') ? 'selected' : '' ?>>Public</option>
                <option value="Private" <?= (isset($formData['school_type']) && $formData['school_type'] === 'Private') ? 'selected' : '' ?>>Private</option>
              </select>
            </div>
          </div>

          <div class="form-grid-2" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Course / Major</label>
              <input type="text" name="course" value="<?= htmlspecialchars($formData['course'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., BS Computer Science">
            </div>
            <div class="form-group">
              <label>Academic Standing</label>
              <input type="text" name="academic_standing" value="<?= htmlspecialchars($formData['academic_standing'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., Dean's List, Good Standing">
            </div>
          </div>

          <div class="form-grid" style="margin-top: 1.5rem;">
            <div class="form-group full-width">
              <label>Essay <span class="required">*</span></label>
              <textarea name="essay" rows="5" placeholder="Explain why you are applying for this scholarship and how the NEAP will help you achieve your educational goals..." required><?= htmlspecialchars($formData['essay'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
          </div>

          <div class="form-grid" style="margin-top: 1.5rem;">
            <div class="form-group full-width">
              <label>Are you willing to render service obligation to the Municipal Government of Naujan? <span class="required">*</span></label>
              <select name="service_obligation" required>
                <option value="">-- Select --</option>
                <option value="Yes" <?= (isset($formData['service_obligation']) && $formData['service_obligation'] === 'Yes') ? 'selected' : '' ?>>Yes</option>
                <option value="No" <?= (isset($formData['service_obligation']) && $formData['service_obligation'] === 'No') ? 'selected' : '' ?>>No</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Section 3: Family Background -->
        <div class="form-section" data-section="3">
          <div class="section-header">
            <div class="section-icon">3</div>
            <h2>Family Background</h2>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label>Father's Name</label>
              <input type="text" name="father_name" value="<?= htmlspecialchars($formData['father_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="form-group">
              <label>Occupation</label>
              <input type="text" name="father_occupation" value="<?= htmlspecialchars($formData['father_occupation'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="form-grid-2" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Mother's Name</label>
              <input type="text" name="mother_name" value="<?= htmlspecialchars($formData['mother_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="form-group">
              <label>Occupation</label>
              <input type="text" name="mother_occupation" value="<?= htmlspecialchars($formData['mother_occupation'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="form-grid" style="margin-top: 1.5rem;">
            <div class="form-group full-width">
              <label>Contact Number/s</label>
              <input type="text" name="parent_contact" value="<?= htmlspecialchars($formData['parent_contact'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="form-grid" style="margin-top: 1.5rem;">
            <div class="form-group full-width">
              <label>Address</label>
              <input type="text" name="parent_address" value="<?= htmlspecialchars($formData['parent_address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>

          <div class="form-grid" style="margin-top: 1.5rem;">
            <div class="form-group full-width">
              <label>Household Annual Income</label>
              <input type="text" name="annual_income" value="<?= htmlspecialchars($formData['annual_income'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., ₱50,000">
            </div>
          </div>
        </div>

        <!-- Section 4: Guardian Information -->
        <div class="form-section" data-section="4">
          <div class="section-header">
            <div class="section-icon">4</div>
            <h2>Guardian Information</h2>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="guardian_name" value="<?= htmlspecialchars($formData['guardian_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="form-group">
              <label>Relationship</label>
              <input type="text" name="guardian_relationship" value="<?= htmlspecialchars($formData['guardian_relationship'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., Parent, Uncle, Aunt">
            </div>
          </div>

          <div class="form-grid-2" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Contact No.</label>
              <input type="text" name="guardian_contact" value="<?= htmlspecialchars($formData['guardian_contact'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="form-group">
              <label>Address</label>
              <input type="text" name="guardian_address" value="<?= htmlspecialchars($formData['guardian_address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
          </div>
        </div>

        <!-- Section 5: Document Uploads -->
        <div class="form-section" data-section="5">
          <div class="section-header">
            <div class="section-icon">5</div>
            <h2>Document Uploads</h2>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label>Affidavit of Undertaking <span class="required">*</span></label>
              <input type="file" name="affidavit_file" accept=".pdf,.jpg,.png" required>
              <div class="file-hint">PDF, JPG, PNG (max 5MB)</div>
            </div>
            <div class="form-group">
              <label>Birth Certificate (PSA/LCR) <span class="required">*</span></label>
              <input type="file" name="birth_certificate" accept=".pdf,.jpg,.png" required>
              <div class="file-hint">PDF, JPG, PNG (max 5MB)</div>
            </div>
          </div>

          <div class="form-grid-2" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Certificate of Residency <span class="required">*</span></label>
              <input type="file" name="residency_cert" accept=".pdf,.jpg,.png" required>
              <div class="file-hint">PDF, JPG, PNG (max 5MB)</div>
            </div>
            <div class="form-group">
              <label>Parent/Guardian ID <span class="required">*</span></label>
              <input type="file" name="guardian_id" accept=".pdf,.jpg,.png" required>
              <div class="file-hint">PDF, JPG, PNG (max 5MB)</div>
            </div>
          </div>

          <div class="form-grid-2" style="margin-top: 1.5rem;">
            <div class="form-group">
              <label>Certificate of Enrollment</label>
              <input type="file" name="enrollment_cert" accept=".pdf,.jpg,.png">
              <div class="file-hint">PDF, JPG, PNG (max 5MB)</div>
            </div>
            <div class="form-group">
              <label>Certificate of Good Moral Character</label>
              <input type="file" name="good_moral" accept=".pdf,.jpg,.png">
              <div class="file-hint">PDF, JPG, PNG (max 5MB)</div>
            </div>
          </div>

          <div class="form-grid" style="margin-top: 1.5rem;">
            <div class="form-group full-width">
              <label>Recent Transcript of Records / Grades</label>
              <input type="file" name="transcript" accept=".pdf,.jpg,.png">
              <div class="file-hint">PDF, JPG, PNG (max 5MB)</div>
            </div>
          </div>
        </div>

        <!-- Section 6: Declaration -->
        <div class="form-section" data-section="6">
          <div class="section-header">
            <div class="section-icon">6</div>
            <H2>Declaration</H2>
          </div>

          <div class="declaration-box">
            <p>
              I hereby declare that the information provided in this application form is true and accurate to the best of my knowledge. 
              I understand that any false information may result in rejection or withdrawal of my educational assistance.
            </p>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label>Signature over Printed Name <span class="required">*</span></label>
              <input type="file" name="signature" accept=".pdf,.jpg,.png" required>
              <div class="file-hint">Upload your signature (PDF, JPG, PNG)</div>
            </div>
            <div class="form-group">
              <label>Date <span class="required">*</span></label>
              <input type="date" name="date_submitted" value="<?= date('Y-m-d') ?>" required>
            </div>
          </div>
        </div>

        <!-- Form action buttons -->
        <div class="form-actions">
          <button type="submit" class="btn btn-primary" id="submitBtn">Submit Application →</button>
        </div>

      </div>
    </form>
  </div>

  <script>
    // User menu toggle
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

    const form = document.getElementById('applicationForm');
    const progressFill = document.getElementById('progressFill');
    
    function updateProgress() {
      const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
      let filled = 0;
      
      inputs.forEach(input => {
        if (input.type === 'file') {
          if (input.files.length > 0) filled++;
        } else if (input.value.trim() !== '') {
          filled++;
        }
      });
      
      const percentage = Math.round((filled / inputs.length) * 100);
      progressFill.style.width = percentage + '%';
    }

    // Update progress on input
    form.addEventListener('input', updateProgress);
    form.addEventListener('change', updateProgress);

    // Initial progress check
    updateProgress();

    form.addEventListener('submit', function(e) {
      const submitBtn = document.getElementById('submitBtn');
      submitBtn.disabled = true;
      submitBtn.textContent = 'Submitting...';
    });

    form.addEventListener('invalid', function(e) {
      e.preventDefault();
      const firstInvalid = form.querySelector(':invalid');
      if (firstInvalid) {
        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstInvalid.focus();
      }
    }, true);
  </script>

</body>
</html>
