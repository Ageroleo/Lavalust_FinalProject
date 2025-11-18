<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile - Applicant</title>
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
      padding: 20px;
    }

    header {
      background: #2e7d32;
      color: #fff;
      width: 100%;
      padding: 20px 0;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
      position: relative;
      margin-bottom: 20px;
    }

    header h1 {
      font-size: 24px;
      margin-bottom: 5px;
    }

    .back-link, .logout {
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

    .back-link:hover, .logout:hover {
      background: #fff;
      color: #2e7d32;
    }

    .container {
      background: #fff;
      max-width: 900px;
      margin: 0 auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    h2 {
      color: #2e7d32;
      margin-bottom: 20px;
      border-bottom: 2px solid #2e7d32;
      padding-bottom: 10px;
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

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      color: #555;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-group input, .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 14px;
      transition: border-color 0.3s ease;
      font-family: inherit;
    }

    .form-group input:focus, .form-group textarea:focus {
      outline: none;
      border-color: #2e7d32;
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .form-row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
    }

    .form-group small {
      display: block;
      margin-top: 5px;
      color: #666;
      font-size: 12px;
    }

    .btn-group {
      display: flex;
      gap: 10px;
      margin-top: 30px;
    }

    .btn {
      padding: 12px 24px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-block;
      text-align: center;
    }

    .btn-primary {
      background: #2e7d32;
      color: #fff;
    }

    .btn-primary:hover {
      background: #1b5e20;
    }

    .btn-secondary {
      background: #757575;
      color: #fff;
    }

    .btn-secondary:hover {
      background: #616161;
    }

    .info-section {
      background: #f9fbe7;
      padding: 20px;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 15px;
    }

    .info-item {
      display: flex;
      flex-direction: column;
    }

    .info-label {
      font-weight: 600;
      color: #555;
      margin-bottom: 5px;
      font-size: 13px;
    }

    .info-value {
      color: #333;
      font-size: 14px;
    }

    .edit-mode {
      display: none;
    }

    .view-mode {
      display: block;
    }

    .edit-mode.active {
      display: block;
    }

    .view-mode.active {
      display: block;
    }

    .password-section {
      margin-top: 30px;
      padding-top: 30px;
      border-top: 2px solid #e0e0e0;
    }

    footer {
      text-align: center;
      padding: 20px;
      margin-top: 40px;
      color: #666;
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .form-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <header>
    <a href="/applicant/dashboard" class="back-link">← Back</a>
    <h1>My Profile</h1>
    <a href="/logout" class="logout">Logout</a>
  </header>

  <div class="container">
    <h2>Profile Information</h2>

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

    <?php if (empty($user)): ?>
      <p>User not found.</p>
    <?php else: ?>
      <!-- View Mode -->
      <div class="view-mode active" id="viewMode">
        <div class="info-section">
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">Last Name:</span>
              <span class="info-value"><?= htmlspecialchars($user['last_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">First Name:</span>
              <span class="info-value"><?= htmlspecialchars($user['first_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Middle Name:</span>
              <span class="info-value"><?= htmlspecialchars($user['middle_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Home Address:</span>
              <span class="info-value"><?= htmlspecialchars($user['address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Birthday:</span>
              <span class="info-value"><?= isset($user['birthday']) && $user['birthday'] ? date('M d, Y', strtotime($user['birthday'])) : 'N/A' ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Age:</span>
              <span class="info-value"><?= htmlspecialchars($user['age'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Civil Status:</span>
              <span class="info-value"><?= htmlspecialchars($user['civil_status'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Contact No.:</span>
              <span class="info-value"><?= htmlspecialchars($user['contact_no'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Place of Birth:</span>
              <span class="info-value"><?= htmlspecialchars($user['birth_place'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Height (cm):</span>
              <span class="info-value"><?= htmlspecialchars($user['height'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Weight (kg):</span>
              <span class="info-value"><?= htmlspecialchars($user['weight'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Email Address:</span>
              <span class="info-value"><?= htmlspecialchars($user['email'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
              <span class="info-label">Special Skills:</span>
              <span class="info-value"><?= htmlspecialchars($user['special_skills'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-primary" onclick="toggleEdit()">Edit Profile</button>
        </div>
      </div>

      <!-- Edit Mode -->
      <div class="edit-mode" id="editMode">
        <form method="POST" action="/applicant/profile/update" onsubmit="return validateForm()">
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

          <div class="password-section">
            <h3 style="color: #2e7d32; margin-bottom: 15px; font-size: 18px;">Change Password (Optional)</h3>
            <div class="form-row">
              <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" minlength="6">
                <small>Leave blank to keep current password. Minimum 6 characters.</small>
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" minlength="6">
              </div>
            </div>
          </div>

          <div class="btn-group">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="toggleEdit()">Cancel</button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>

  <footer>
    &copy; <?= date('Y') ?> Municipality of Naujan | Educational Assistance Program
  </footer>

  <script>
    function toggleEdit() {
      const viewMode = document.getElementById('viewMode');
      const editMode = document.getElementById('editMode');
      
      if (viewMode.classList.contains('active')) {
        viewMode.classList.remove('active');
        editMode.classList.add('active');
      } else {
        viewMode.classList.add('active');
        editMode.classList.remove('active');
      }
    }

    function validateForm() {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm_password').value;

      if (password || confirmPassword) {
        if (password !== confirmPassword) {
          alert('Passwords do not match!');
          return false;
        }
        if (password.length > 0 && password.length < 6) {
          alert('Password must be at least 6 characters long!');
          return false;
        }
      }

      return true;
    }
  </script>

</body>
</html>
