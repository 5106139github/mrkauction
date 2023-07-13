<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Account</title>
  <style>
    /* CSS styles for the account section */
    h2,h3,h4 {
      text-align: center;
    }

    table {
      margin: 0 auto;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    /* CSS styles for the back button */
    .back-button {
      margin-top: 20px;
      text-align: center;
    }

    .back-button a {
      padding: 10px 20px;
      background-color: #ff6600;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }

    .back-button a:hover {
      background-color: #ff3300;
    }
  </style>
</head>
<body>
  <?php
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // Connect to the database
    $host = 'localhost';
    $user = 'root';
    $password = ''; // Replace with your actual database password
    $database = 'project'; // Replace with your actual database name

    $conn = mysqli_connect($host, $user, $password, $database);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve user's account information from the database
    $query = "SELECT username, email, phone_number, address, city, district, state, pincode, (SELECT COUNT(DISTINCT item_id) FROM winners WHERE bidder_name = '$username') AS auctions_won, COUNT(bids.bidder_name) AS bids_made FROM users LEFT JOIN bids ON users.username = bids.bidder_name WHERE username='$username'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      $email = $row['email'];
      $phone_number = $row['phone_number'];
      $address = $row['address'];
      $city = $row['city'];
      $district = $row['district'];
      $state = $row['state'];
      $pincode = $row['pincode'];
      $auctions_won = $row['auctions_won'] ?? 0;
      $bids_made = $row['bids_made'] ?? 0;

      // Display user's account information
      echo "<h2>My Account</h2>";
      echo "<table>";
      echo "<tr><th>Username</th><td>$username</td></tr>";
      echo "<tr><th>Email</th><td>$email</td></tr>";
      echo "<tr><th>Phone Number</th><td>$phone_number</td></tr>";
      echo "<tr><th>Address</th><td>$address</td></tr>";
      echo "<tr><th>City</th><td>$city</td></tr>";
      echo "<tr><th>District</th><td>$district</td></tr>";
      echo "<tr><th>State</th><td>$state</td></tr>";
      echo "<tr><th>Pincode</th><td>$pincode</td></tr>";
      echo "<tr><th>Auctions Won</th><td>$auctions_won</td></tr>";
      echo "<tr><th>Bids Made</th><td>$bids_made</td></tr>";
      echo "</table>";
    } else {
      echo "<p>Failed to retrieve account information.</p>";
    }
	 $auction_query = "SELECT item_id, bid_amount FROM winners WHERE bidder_name = '$username'";
      $auction_result = mysqli_query($conn, $auction_query);

      if (mysqli_num_rows($auction_result) > 0) {
        echo "<h3>Auction Won</h3>";
        while ($auction_row = mysqli_fetch_assoc($auction_result)) {
          $item_id = $auction_row['item_id'];
          $winning_price = $auction_row['bid_amount'];
          echo "<table>";
		  echo "<tr><th>Item ID</th><td> $item_id</td>";
          echo "<th>Winning Price</th><td>₹$winning_price</td>";
		  echo "</tr>";
		  echo "</table>";
        }
        echo "</td></tr>";
      } else {
        echo "<h4>No auctions won</h4>";
      }
// Close the database connection_aborted
    mysqli_close($conn);
  } else {
    echo "<p>Please log in to view your account.</p>";
  }
  ?>

  <div class="back-button">
    <a href="home.php">Back to Home</a>
  </div>
</body>
</html>
