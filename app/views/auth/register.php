<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Scholarship System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * { 
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    html, body {
      height: 100%;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
      margin: 0;
      padding: 0;
    }

    body {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px 16px;
    }

    /* Main Container */
    .login-container {
      width: 100%;
      max-width: 720px;
      background: #ffffff;
      border-radius: 18px;
      box-shadow: 0 14px 40px rgba(0, 0, 0, 0.12);
      overflow: hidden;
      display: flex;
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Left Panel - Branding */
    .login-branding {
      flex: 0.85;
      background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
      color: #ffffff;
      padding: 26px 26px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .login-branding::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: pulse 15s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 0.3; }
    }

    .logo-container {
      position: relative;
      z-index: 1;
      margin-bottom: 18px;
    }

    .logo-container img {
      width: 140px;
      height: auto;
      filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    .branding-content {
      position: relative;
      z-index: 1;
    }

    .branding-content h1 {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 10px;
      line-height: 1.3;
      letter-spacing: -0.5px;
    }

    .branding-content p {
      font-size: 14px;
      font-weight: 400;
      line-height: 1.6;
      opacity: 0.95;
    }

    .feature-list {
      margin-top: 22px;
      text-align: left;
    }

    .feature-item {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 10px;
      padding: 10px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      backdrop-filter: blur(10px);
    }

    .feature-icon {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    /* Right Panel - Form */
    .login-form-panel {
      flex: 1.1;
      padding: 40px 34px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-header {
      margin-bottom: 28px;
    }

    .form-header h2 {
      font-size: 26px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 6px;
      letter-spacing: -0.5px;
    }

    .form-header p {
      font-size: 14px;
      color: #666;
      font-weight: 400;
    }

    /* Error/Success Messages */
    .alert {
      padding: 16px 20px;
      border-radius: 12px;
      margin-bottom: 25px;
      font-size: 14px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 12px;
      animation: slideIn 0.4s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .alert-error {
      background-color: #fef2f2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }

    .alert-success {
      background-color: #f0fdf4;
      color: #166534;
      border: 1px solid #bbf7d0;
    }

    .alert i {
      font-size: 18px;
    }

    /* Form Fields */
    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      font-weight: 600;
      color: #1a1a1a;
      margin-bottom: 8px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 16px;
      pointer-events: none;
      transition: color 0.3s ease;
    }

    .password-toggle {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #9ca3af;
      font-size: 16px;
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.3s ease;
      z-index: 10;
    }

    .password-toggle:hover {
      color: #2e7d32;
    }

    .password-toggle:focus {
      outline: none;
      color: #2e7d32;
    }

    .form-control {
      width: 100%;
      height: 46px;
      padding: 0 16px 0 44px;
      font-size: 14px;
      font-weight: 400;
      color: #1a1a1a;
      background: #f9fafb;
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      outline: none;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    .password-wrapper .form-control {
      padding-right: 50px;
    }

    .form-control:focus {
      background: #ffffff;
      border-color: #2e7d32;
      box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
    }

    .password-requirements {
      margin-top: 8px;
      padding: 12px;
      background: #f9fafb;
      border-radius: 8px;
      font-size: 12px;
    }

    .password-requirements h4 {
      font-size: 13px;
      font-weight: 600;
      color: #1a1a1a;
      margin-bottom: 8px;
    }

    .requirement-item {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 4px;
      color: #6b7280;
      transition: color 0.2s;
    }

    .requirement-item.valid {
      color: #10b981;
    }

    .requirement-item.invalid {
      color: #6b7280;
    }

    .requirement-item i {
      font-size: 10px;
      width: 14px;
    }

    .password-match {
      margin-top: 8px;
      font-size: 12px;
      display: flex;
      align-items: center;
      gap: 6px;
      color: #6b7280;
    }

    .password-match.valid {
      color: #10b981;
    }

    .password-match.invalid {
      color: #ef4444;
    }

    .password-match i {
      font-size: 12px;
    }

    .form-control:focus + .input-icon {
      color: #2e7d32;
    }

    .form-control::placeholder {
      color: #9ca3af;
    }

    /* Submit Button */
    .btn-submit {
      width: 100%;
      height: 54px;
      background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
      color: #ffffff;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
      margin-top: 10px;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(46, 125, 50, 0.4);
    }

    .btn-submit:active {
      transform: translateY(0);
    }

    /* Footer Links */
    .form-footer {
      text-align: center;
      margin-top: 30px;
      padding-top: 30px;
      border-top: 1px solid #e5e7eb;
    }

    .form-footer p {
      font-size: 14px;
      color: #666;
      font-weight: 400;
    }

    .form-footer a {
      color: #2e7d32;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .form-footer a:hover {
      color: #1b5e20;
      text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .login-container {
        flex-direction: column;
        border-radius: 16px;
      }

      .login-branding {
        padding: 40px 30px;
      }

      .feature-list {
        display: none;
      }

      .branding-content h1 {
        font-size: 24px;
      }

      .branding-content p {
        font-size: 14px;
      }

      .login-form-panel {
        padding: 40px 30px;
      }

      .form-header h2 {
        font-size: 26px;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 0;
      }

      .login-container {
        border-radius: 0;
        box-shadow: none;
      }

      .login-branding {
        padding: 30px 20px;
      }

      .logo-container img {
        width: 100px;
      }

      .login-form-panel {
        padding: 30px 20px;
      }

      .form-control,
      .btn-submit {
        height: 48px;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <!-- Left Panel - Branding -->
    <div class="login-branding">
      <div class="logo-container">
        <img src="<?= BASE_URL ?>/public/neap-logo.png" alt="NEAP Logo">
      </div>
      <div class="branding-content">
        <h1>Naujan Educational Assistance Program</h1>
        <p>Join the Municipality of Naujan Scholarship Portal</p>
      </div>
      <div class="feature-list">
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <div>
            <strong>Educational Support</strong><br>
            <small>Access scholarship opportunities</small>
          </div>
        </div>
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fas fa-clock"></i>
          </div>
          <div>
            <strong>Quick Processing</strong><br>
            <small>Track your application status</small>
          </div>
        </div>
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <div>
            <strong>Secure Platform</strong><br>
            <small>Your data is protected</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Panel - Register Form -->
    <div class="login-form-panel">
      <div class="form-header">
        <h2>Welcome to the Naujan Educational Assistance Program</h2>
        <p>Sign up to start your scholarship application</p>
      </div>

      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i>
          <span><?= htmlspecialchars($_SESSION['success']) ?></span>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-error">
          <i class="fas fa-exclamation-circle"></i>
          <span><?= htmlspecialchars($error) ?></span>
        </div>
      <?php endif; ?>

      <form class="login-form" method="POST" action="<?= BASE_URL ?>/register">
        <div class="form-group">
          <label for="fullname">Full Name</label>
          <div class="input-wrapper">
            <input 
              type="text" 
              id="fullname" 
              name="fullname" 
              class="form-control" 
              placeholder="Enter your full name"
              required
              autocomplete="name"
            >
            <i class="fas fa-user input-icon"></i>
          </div>
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <div class="input-wrapper">
            <input 
              type="email" 
              id="email" 
              name="email" 
              class="form-control" 
              placeholder="Enter your email"
              required
              autocomplete="email"
            >
            <i class="fas fa-envelope input-icon"></i>
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper password-wrapper">
            <input 
              type="password" 
              id="password" 
              name="password" 
              class="form-control" 
              placeholder="Enter your password"
              required
              autocomplete="new-password"
              minlength="8"
            >
            <i class="fas fa-lock input-icon"></i>
            <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="form-group">
          <label for="confirm_password">Confirm Password</label>
          <div class="input-wrapper password-wrapper">
            <input 
              type="password" 
              id="confirm_password" 
              name="confirm_password" 
              class="form-control" 
              placeholder="Confirm your password"
              required
              autocomplete="new-password"
            >
            <i class="fas fa-lock input-icon"></i>
            <button type="button" class="password-toggle" id="toggleConfirmPassword" aria-label="Show password">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="password-match" id="passwordMatch" style="display: none;">
            <i class="fas fa-circle"></i>
            <span>Passwords match</span>
          </div>
        </div>

        <button type="submit" class="btn-submit">
          <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
          Create Account
        </button>
      </form>

      <div class="form-footer">
        <p>
          Already have an account? 
          <a href="<?= BASE_URL ?>/login">Login here</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const passwordIcon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      // Toggle icon
      if (type === 'text') {
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
        togglePassword.setAttribute('aria-label', 'Hide password');
      } else {
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
        togglePassword.setAttribute('aria-label', 'Show password');
      }
    });

    // Toggle confirm password visibility
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const confirmPasswordIcon = toggleConfirmPassword.querySelector('i');

    toggleConfirmPassword.addEventListener('click', function() {
      const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPasswordInput.setAttribute('type', type);
      
      // Toggle icon
      if (type === 'text') {
        confirmPasswordIcon.classList.remove('fa-eye');
        confirmPasswordIcon.classList.add('fa-eye-slash');
        toggleConfirmPassword.setAttribute('aria-label', 'Hide password');
      } else {
        confirmPasswordIcon.classList.remove('fa-eye-slash');
        confirmPasswordIcon.classList.add('fa-eye');
        toggleConfirmPassword.setAttribute('aria-label', 'Show password');
      }
    });

    // Password validation
    function validatePassword(password) {
      const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password)
      };
      return requirements;
    }

    function updateRequirementUI(requirements) {
      const reqIds = {
        length: 'req-length',
        uppercase: 'req-uppercase',
        lowercase: 'req-lowercase',
        number: 'req-number'
      };

      Object.keys(requirements).forEach(key => {
        const element = document.getElementById(reqIds[key]);
        const icon = element.querySelector('i');
        if (requirements[key]) {
          element.classList.remove('invalid');
          element.classList.add('valid');
          icon.classList.remove('fa-circle');
          icon.classList.add('fa-check-circle');
        } else {
          element.classList.remove('valid');
          element.classList.add('invalid');
          icon.classList.remove('fa-check-circle');
          icon.classList.add('fa-circle');
        }
      });
    }

    function checkPasswordMatch() {
      const password = passwordInput.value;
      const confirmPassword = confirmPasswordInput.value;
      const matchElement = document.getElementById('passwordMatch');
      const icon = matchElement.querySelector('i');
      const span = matchElement.querySelector('span');

      if (confirmPassword.length === 0) {
        matchElement.style.display = 'none';
        return;
      }

      matchElement.style.display = 'flex';

      if (password === confirmPassword && password.length > 0) {
        matchElement.classList.remove('invalid');
        matchElement.classList.add('valid');
        icon.classList.remove('fa-times-circle', 'fa-circle');
        icon.classList.add('fa-check-circle');
        span.textContent = 'Passwords match';
      } else {
        matchElement.classList.remove('valid');
        matchElement.classList.add('invalid');
        icon.classList.remove('fa-check-circle', 'fa-circle');
        icon.classList.add('fa-times-circle');
        span.textContent = 'Passwords do not match';
      }
    }

    // Validate password on input
    passwordInput.addEventListener('input', function() {
      const password = this.value;
      const requirements = validatePassword(password);
      updateRequirementUI(requirements);
      checkPasswordMatch();
    });

    // Check password match on confirm password input
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);

    // Form submission validation
    document.querySelector('.login-form').addEventListener('submit', function(e) {
      const password = passwordInput.value;
      const confirmPassword = confirmPasswordInput.value;
      const requirements = validatePassword(password);

      // Check if all requirements are met
      const allValid = Object.values(requirements).every(req => req === true);

      if (!allValid) {
        e.preventDefault();
        alert('Please ensure your password meets all requirements.');
        return false;
      }

      if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match. Please try again.');
        return false;
      }
    });
  </script>

</body>
</html>
