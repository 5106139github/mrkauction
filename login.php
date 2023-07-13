<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    .password-toggle {
      position: relative;
    }

    .password-toggle input[type="password"] {
      padding-right: 30px;
    }

    .password-toggle .toggle-icon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
  <script>
    function togglePassword() {
      var passwordField = document.getElementById("password");
      var toggleIcon = document.getElementById("toggle-icon");

      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.className = "fa fa-eye-slash";
      } else {
        passwordField.type = "password";
        toggleIcon.className = "fa fa-eye";
      }
    }
  </script>
</head>
<body>
  <div class="header">
    <h2>Login</h2>
  </div>
     
  <form method="post" action="login.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
      <label>Username</label>
      <input type="text" name="username">
    </div>
    <div class="input-group password-toggle">
      <label>Password</label>
      <input type="password" name="password" id="password">
      <span class="toggle-icon fa fa-eye" id="toggle-icon" onclick="togglePassword()"></span>
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="login_user">Login</button>
    </div>
    <p>
      Not yet a member? <a href="register.php">Sign up</a>
    </p>
  </form>
</body>
</html>
