<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Phone Number (10 digits)</label>
  	  <input type="text" name="phone_number" pattern="[0-9]{10}" value="<?php echo $phone_number; ?>" required>
  	</div>
  	<div class="input-group">
  	  <label>Address</label>
  	  <input type="text" name="address" value="<?php echo $address; ?>">
  	</div>
  	<div class="input-group">
  	  <label>City</label>
  	  <input type="text" name="city" value="<?php echo $city; ?>">
  	</div>
  	<div class="input-group">
  	  <label>District</label>
  	  <input type="text" name="district" value="<?php echo $district; ?>">
  	</div>
  	<div class="input-group">
  	  <label>State</label>
  	  <input type="text" name="state" value="<?php echo $state; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Pincode</label>
  	  <input type="text" name="pincode" pattern="[0-9]{6}" value="<?php echo $pincode; ?>">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>
