<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NEAP Scholarship Application Form</title>
  <link rel="stylesheet" href="/public/css/style.css">
  <style>
    body { font-family: Arial, sans-serif; background:#f8f9fa; margin:0; padding:20px; }
    form { background:#fff; padding:25px; border-radius:10px; max-width:900px; margin:auto; box-shadow:0 0 10px rgba(0,0,0,0.1);}
    h2 { border-bottom:2px solid #007bff; padding-bottom:5px; color:#007bff; }
    input, select, textarea { width:100%; padding:8px; margin:5px 0 15px; border:1px solid #ccc; border-radius:5px; }
    label { font-weight:bold; }
    .row { display:flex; gap:10px; flex-wrap:wrap; }
    .col { flex:1; min-width:200px; }
    .submit-btn { background:#007bff; color:#fff; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; }
    .submit-btn:hover { background:#0056b3; }
    .back-link {
      display: inline-block;
      margin-top: 15px;
      text-decoration: none;
      color: #007bff;
    }
    .alert {
      max-width: 900px;
      margin: 0 auto 20px;
      padding: 12px 18px;
      border-radius: 8px;
      font-size: 14px;
      border: 1px solid transparent;
    }

    .alert-error {
      background: #ffebee;
      border-color: #ffcdd2;
      color: #b71c1c;
    }
  </style>
</head>
<body>

<?php if (!empty($_SESSION['error_message'])): ?>
  <div class="alert alert-error">
    <?= htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8'); ?>
  </div>
  <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<form action="/apply/submit" method="POST" enctype="multipart/form-data">
  <h2>Personal Information</h2>
  <div class="row">
    <div class="col">
      <label>Last Name</label>
      <input type="text" name="last_name" required>
    </div>
    <div class="col">
      <label>Given Name</label>
      <input type="text" name="first_name" required>
    </div>
    <div class="col">
      <label>Middle Name</label>
      <input type="text" name="middle_name">
    </div>
  </div>

  <label>Home Address</label>
  <input type="text" name="address" placeholder="House No., Street, Barangay, Municipality, Province" required>

  <div class="row">
    <div class="col">
      <label>Birthday</label>
      <input type="date" name="birthday" required>
    </div>
    <div class="col">
      <label>Age</label>
      <input type="number" name="age" min="1" required>
    </div>
    <div class="col">
      <label>Civil Status</label>
      <input type="text" name="civil_status">
    </div>
  </div>

  <div class="row">
    <div class="col">
      <label>Contact No.</label>
      <input type="text" name="contact_no" required>
    </div>
    <div class="col">
      <label>Place of Birth</label>
      <input type="text" name="birth_place">
    </div>
  </div>

  <div class="row">
    <div class="col">
      <label>Height (cm)</label>
      <input type="text" name="height">
    </div>
    <div class="col">
      <label>Weight (kg)</label>
      <input type="text" name="weight">
    </div>
  </div>

  <label>Email Address</label>
  <input type="email" name="email" required>

  <label>Special Skills</label>
  <input type="text" name="special_skills">

  <h2>Educational Background</h2>
  <label>Current School / College / University</label>
  <input type="text" name="school_name" required>

  <div class="row">
    <div class="col">
      <label>Year Level</label>
      <input type="text" name="year_level" required>
    </div>
    <div class="col">
      <label>School Type</label>
      <select name="school_type">
        <option value="Public">Public</option>
        <option value="Private">Private</option>
      </select>
    </div>
  </div>

  <label>Course / Major</label>
  <input type="text" name="course">

  <label>Academic Standing</label>
  <input type="text" name="academic_standing">

  <h2>Essay</h2>
  <textarea name="essay" rows="5" placeholder="Explain why you are applying and how NEAP will help you..." required></textarea>

  <label>Are you willing to render service obligation to the Municipal Government of Naujan?</label>
  <select name="service_obligation" required>
    <option value="">-- Select --</option>
    <option value="Yes">Yes</option>
    <option value="No">No</option>
  </select>

  <h2>Family Background</h2>
  <div class="row">
    <div class="col">
      <label>Father’s Name</label>
      <input type="text" name="father_name">
    </div>
    <div class="col">
      <label>Occupation</label>
      <input type="text" name="father_occupation">
    </div>
  </div>

  <div class="row">
    <div class="col">
      <label>Mother’s Name</label>
      <input type="text" name="mother_name">
    </div>
    <div class="col">
      <label>Occupation</label>
      <input type="text" name="mother_occupation">
    </div>
  </div>

  <label>Contact Number/s</label>
  <input type="text" name="parent_contact">

  <label>Address</label>
  <input type="text" name="parent_address">

  <label>Household Annual Income</label>
  <input type="text" name="annual_income">

  <h2>Parent/Guardian Information</h2>
  <div class="row">
    <div class="col">
      <label>Name</label>
      <input type="text" name="guardian_name">
    </div>
    <div class="col">
      <label>Relationship</label>
      <input type="text" name="guardian_relationship">
    </div>
  </div>

  <label>Contact No.</label>
  <input type="text" name="guardian_contact">

  <label>Address</label>
  <input type="text" name="guardian_address">

  <h2>Upload Requirements</h2>
  <p><small>Accepted file types: PDF, JPG, PNG (max 5MB each)</small></p>

  <label>Affidavit of Undertaking</label>
  <input type="file" name="affidavit_file" accept=".pdf,.jpg,.png" required>

  <label>Birth Certificate (PSA/LCR)</label>
  <input type="file" name="birth_certificate" accept=".pdf,.jpg,.png" required>

  <label>Certificate of Residency</label>
  <input type="file" name="residency_cert" accept=".pdf,.jpg,.png" required>

  <label>Parent/Guardian ID</label>
  <input type="file" name="guardian_id" accept=".pdf,.jpg,.png" required>

  <label>Certificate of Enrollment</label>
  <input type="file" name="enrollment_cert" accept=".pdf,.jpg,.png">

  <label>Certificate of Good Moral Character</label>
  <input type="file" name="good_moral" accept=".pdf,.jpg,.png">

  <label>Recent Transcript of Records / Grades</label>
  <input type="file" name="transcript" accept=".pdf,.jpg,.png">

  <h2>Applicant’s Declaration</h2>
  <p>
    I hereby declare that the information provided in this application form is true and accurate to the best of my knowledge. 
    I understand that any false information may result in rejection or withdrawal of my educational assistance.
  </p>
  <label>Signature over Printed Name</label>
  <input type="file" name="transcript" accept=".pdf,.jpg,.png">
  
  <div class="row">
    <div class="col">
      <label>Date</label>
      <input type="date" name="date_submitted" required>
    </div>
  </div>

  <button type="submit" class="submit-btn">Submit Application</button>
  <a href="/" class="back-link">← Back to Homepage</a>  
</form>
</body>
</html>
