<?php
session_start();

// initializing variables
$username = "";
$email = "";
$phone_number = "";
$address = "";
$city = "";
$district = "";
$state = "";
$pincode = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'project');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_1']);
  $phone_number = mysqli_real_escape_string($db, $_POST['phone_number']);
  $address = mysqli_real_escape_string($db, $_POST['address']);
  $city = mysqli_real_escape_string($db, $_POST['city']);
  $district = mysqli_real_escape_string($db, $_POST['district']);
  $state = mysqli_real_escape_string($db, $_POST['state']);
  $pincode = mysqli_real_escape_string($db, $_POST['pincode']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  }
  if (empty($phone_number)) { array_push($errors, "Phone number is required"); }
  if (empty($address)) { array_push($errors, "Address is required"); }
  if (empty($city)) { array_push($errors, "City is required"); }
  if (empty($district)) { array_push($errors, "District is required"); }
  if (empty($state)) { array_push($errors, "State is required"); }
  if (empty($pincode)) { array_push($errors, "Pincode is required"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    $password = ($password_1);//encrypt the password before saving in the database

    $query = "INSERT INTO users (username, email, password, phone_number, address, city, district, state, pincode) 
              VALUES('$username', '$email', '$password', '$phone_number', '$address', '$city', '$district', '$state', '$pincode')";
    mysqli_query($db, $query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: home.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = ($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password ='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      $username = $_SESSION['username'];
      header('location: home.php');
    } else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}

// Check if the user is logged in and retrieve the username
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
?>
