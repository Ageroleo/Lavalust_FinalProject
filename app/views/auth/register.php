<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | Naujan Scholarship System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }
    html, body {
      height: 100%;
      font-family: 'Open Sans', sans-serif;
    }
    body {
      background: hsl(86, 85%, 95%);
      margin: 0;
      padding: 0;
    }

    /* Buttons */
    .btn {
      display: block;
      background: hsl(86, 76%, 71%);
      color: #fff;
      text-decoration: none;
      margin: 20px 0;
      padding: 15px 15px;
      border-radius: 5px;
      position: relative;
      text-align: center;
    }
    .btn:hover {
      background: hsl(86, 66%, 61%);
    }

    /* Form styling */
    .form fieldset {
      border: none;
      padding: 0;
      margin: 20px 0;
      position: relative;
    }
    .form input {
      width: 100%;
      height: 48px;
      color: hsl(0, 0%, 20%);
      padding: 15px 40px 15px 15px;
      border-radius: 5px;
      font-size: 14px;
      outline: none !important;
      border: 1px solid rgba(0, 0, 0, 0.3);
      box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.2);
    }
    .form button {
      width: 100%;
      outline: none !important;
      background: linear-gradient(-5deg, hsl(86, 61%, 44%), hsl(86, 65%, 54%));
      border: none;
      text-transform: uppercase;
      font-weight: bold;
      color: #fff;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0 3px 0 rgba(86, 121, 44, 0.3);
      cursor: pointer;
    }

    /* Signup box */
    .signup {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1;
      width: 800px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 3px 25px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      display: flex;
    }
    .signup-connect,
    .signup-classic {
      width: 50%;
      padding: 30px 50px;
    }

    .signup-connect {
      background: linear-gradient(134deg, hsl(44, 96%, 65%), hsl(34, 95%, 45%));
      color: #fff;
      text-align: center;
    }
    .signup-connect img {
      width: 120px;
      height: auto;
      margin-bottom: 20px;
    }
    .signup-connect h1 {
      font-size: 30px;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    .signup-connect p {
      font-size: 15px;
      line-height: 1.5;
    }

    .signup-classic h2 {
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      text-transform: uppercase;
      margin-bottom: 20px;
      color: hsl(0, 0.00%, 0.00%);
    }

    .signup-classic fieldset::after {
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      content: "\f007";
      position: absolute;
      right: 15px;
      top: 17px;
      width: 20px;
      color: rgba(0, 0, 0, 0.2);
      text-align: center;
    }
    .signup-classic fieldset.email::after {
      content: "\f0e0";
    }
    .signup-classic fieldset.password::after {
      content: "\f023";
    }

    .signup-classic fieldset.name::after {
      content: "\f2bd";
    }
    
    a {
      color: hsl(34, 95%, 45%);
      text-decoration: none;
      font-weight: 600;
    }
    a:hover {
      text-decoration: underline;
    }

    /* Notification styling */
    .error {
      text-align: center;
      color: red;
      margin-bottom: 15px;
      font-size: 14px;
    }
    .success {
      text-align: center;
      color: #1b5e20;
      background: #c8e6c9;
      padding: 10px;
      border-radius: 6px;
      font-weight: 600;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <div class="signup">
    <div class="signup-connect">
      <img src="<?= BASE_URL ?>/public/neap-logo.png" alt="Municipality Logo">
      <h1>Naujan Educational Assistance Program</h1>
      <p>Join the Municipality of Naujan<br>Scholarship Portal and apply today!</p>
    </div>

    <div class="signup-classic">
      <h2>Register</h2>

      <?php if (!empty($_SESSION['success'])): ?>
        <p class="success"><?= htmlspecialchars($_SESSION['success']) ?></p>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form class="form" method="POST" action="<?= BASE_URL ?>/register">
        <fieldset class="name">
          <input type="text" name="fullname" placeholder="Full Name" required>
        </fieldset>

        <fieldset class="email">
          <input type="email" name="email" placeholder="Email" required>
        </fieldset>

        <fieldset class="password">
          <input type="password" name="password" placeholder="Password" required>
        </fieldset>

        <button type="submit">Register</button>
      </form>

      <p>Already have an account? 
        <a href="<?= BASE_URL ?>/login">Login here</a>
      </p>
    </div>
  </div>

</body>
</html>
