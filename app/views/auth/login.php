<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Scholarship System </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; }
    html, body {
      height: 100%;
      font-family: 'Open Sans', sans-serif;
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
      text-align: center;
    }
    .btn:hover {
      background: hsl(86, 66%, 61%);
    }

    /* Form */
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

    /* Signup box layout */
    .signup {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
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

    .signup-connect h1 {
      font-size: 26px;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    .signup-connect img {
      width: 120px;
      height: auto;
      margin-bottom: 20px;
    }

    .signup-classic h2 {
      font-size: 22px;
      text-align: center;
      text-transform: uppercase;
      font-weight: bold;
      margin-top: 20px;
      margin-bottom: 40px;
    }

    .signup-classic fieldset::after {
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      position: absolute;
      right: 15px;
      top: 17px;
      width: 20px;
      color: rgba(0, 0, 0, 0.2);
      text-align: center;
    }
    .signup-classic fieldset.email::after { content: "\f0e0"; }
    .signup-classic fieldset.password::after { content: "\f023"; }

    .signup-classic p {
      text-align: center;
      margin-top: 15px;
    }
    .signup-classic a {
      color: hsl(34, 95%, 45%);
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="signup">
    <!-- LEFT PANEL (Logo + Info) -->
    <div class="signup-connect">
      <img src="<?= BASE_URL ?>/public/neap-logo.png" alt="Municipality Logo">
      <h1>Naujan Educational Assistance Program</h1>
      <p>Welcome to the Municipality of Naujan<br>Scholarship Portal</p>
    </div>

    <!-- RIGHT PANEL (Form) -->
    <div class="signup-classic">
      <h2>LOGIN</h2>
      <form class="form" method="POST" action="<?= BASE_URL ?>/login">
        <fieldset class="email">
          <input type="text" name="email" placeholder="Email" required>
        </fieldset>
        <fieldset class="password">
          <input type="password" name="password" placeholder="Password" required>
        </fieldset>
        <button type="submit">Login</button>
      </form>
      <p>
        Don’t have an account?
        <a href="<?= BASE_URL ?>/register">Sign up</a>
      </p>
    </div>
  </div>

</body>
</html>
