<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Application - Admin</title>
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
      background: #1b5e20;
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
      color: #1b5e20;
    }

    .container {
      background: #fff;
      max-width: 1000px;
      margin: 0 auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    h2 {
      color: #1b5e20;
      margin-bottom: 20px;
      border-bottom: 2px solid #1b5e20;
      padding-bottom: 10px;
    }

    .section {
      margin-bottom: 30px;
    }

    .section h3 {
      color: #33691e;
      margin-bottom: 15px;
      font-size: 18px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 15px;
      margin-bottom: 20px;
    }

    .info-item {
      display: flex;
      flex-direction: column;
    }

    .info-label {
      font-weight: 600;
      color: #555;
      margin-bottom: 5px;
      font-size: 14px;
    }

    .info-value {
      color: #333;
      padding: 8px;
      background: #f9fbe7;
      border-radius: 4px;
    }

    .status-badge {
      display: inline-block;
      padding: 6px 16px;
      border-radius: 12px;
      font-size: 14px;
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

    .actions {
      display: flex;
      gap: 10px;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 2px solid #e0e0e0;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-block;
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

    .essay-box {
      background: #f9fbe7;
      padding: 15px;
      border-radius: 6px;
      border-left: 4px solid #33691e;
      margin-top: 10px;
      white-space: pre-wrap;
      line-height: 1.6;
    }

    footer {
      text-align: center;
      padding: 20px;
      margin-top: 40px;
      color: #666;
      font-size: 14px;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .container {
        max-width: 95%;
        padding: 25px;
      }

      .info-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 768px) {
      body {
        padding: 10px;
      }

      header {
        padding: 15px 0;
      }

      header h1 {
        font-size: 20px;
        padding: 0 80px;
      }

      .back-link, .logout {
        padding: 5px 10px;
        font-size: 13px;
      }

      .back-link {
        left: 15px;
      }

      .logout {
        right: 15px;
      }

      .container {
        max-width: 100%;
        padding: 20px;
        border-radius: 8px;
      }

      h2 {
        font-size: 20px;
      }

      .section {
        margin-bottom: 25px;
      }

      .section h3 {
        font-size: 16px;
      }

      .info-grid {
        grid-template-columns: 1fr;
        gap: 12px;
      }

      .info-label {
        font-size: 12px;
      }

      .info-value {
        font-size: 14px;
        padding: 10px;
      }

      .essay-box {
        font-size: 14px;
        padding: 15px;
      }

      .actions {
        flex-direction: column;
        gap: 10px;
      }

      .btn {
        width: 100%;
        text-align: center;
        padding: 12px;
      }
    }

    @media (max-width: 480px) {
      header h1 {
        font-size: 18px;
        padding: 0 70px;
      }

      .back-link span, .logout span {
        display: none;
      }

      .container {
        padding: 15px;
      }

      h2 {
        font-size: 18px;
      }

      .section h3 {
        font-size: 14px;
      }

      .info-value {
        font-size: 13px;
        padding: 8px;
      }
    }
  </style>
</head>
<body>

  <header>
    <a href="/admin/applications" class="back-link">← Back</a>
    <h1>Application Details</h1>
    <a href="/logout" class="logout">Logout</a>
  </header>

  <div class="container">
    <?php if (empty($application)): ?>
      <p>Application not found.</p>
    <?php else: ?>
      <div class="section">
        <h2>Application #<?= htmlspecialchars($application['id'] ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
        <div style="margin-top: 10px;">
          <span class="status-badge status-<?= strtolower($application['status'] ?? 'pending') ?>">
            <?= htmlspecialchars($application['status'] ?? 'Pending', ENT_QUOTES, 'UTF-8') ?>
          </span>
        </div>
      </div>

      <div class="section">
        <h3>Personal Information</h3>
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
        <div class="info-item" style="margin-top: 15px;">
          <span class="info-label">Address</span>
          <span class="info-value"><?= htmlspecialchars($application['address'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      </div>

      <div class="section">
        <h3>Educational Background</h3>
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
        </div>
      </div>

      <div class="section">
        <h3>Essay</h3>
        <div class="essay-box"><?= htmlspecialchars($application['essay'] ?? 'No essay provided.', ENT_QUOTES, 'UTF-8') ?></div>
      </div>

      <div class="section">
        <h3>Family Background</h3>
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
            <span class="info-label">Annual Income</span>
            <span class="info-value"><?= htmlspecialchars($application['annual_income'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      </div>

      <div class="section">
        <h3>Application Details</h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Date Submitted</span>
            <span class="info-value"><?= isset($application['date_submitted']) ? date('M d, Y h:i A', strtotime($application['date_submitted'])) : 'N/A' ?></span>
          </div>
          <div class="info-item">
            <span class="info-label">Service Obligation</span>
            <span class="info-value"><?= htmlspecialchars($application['service_obligation'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      </div>

      <?php if (($application['status'] ?? 'pending') === 'pending'): ?>
        <div class="actions">
          <a href="/admin/approve/<?= $application['id'] ?? '' ?>" class="btn btn-approve" onclick="return confirm('Are you sure you want to approve this application?')">Approve Application</a>
          <a href="/admin/reject/<?= $application['id'] ?? '' ?>" class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this application?')">Reject Application</a>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <footer>
    &copy; <?= date('Y') ?> Municipality of Naujan | Scholarship Management System
  </footer>

</body>
</html>

