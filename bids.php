<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Bids</title>
  <style>
    /* CSS styles for the bids section */
    h2 {
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

    // Display user's bids
    echo "<h2>Your Bids</h2>";

    // Retrieve user's bids from the database
    $query = "SELECT * FROM bids WHERE bidder_name='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
      echo "<p>You have not placed any bids yet.</p>";
    } else {
      echo "<table>";
      echo "<tr><th>Item ID</th><th>Bid Amount</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        $item_name = $row['item_id'];
        $amount = $row['bid_amount'];
        echo "<tr><td>$item_name</td><td>₹$amount</td></tr>";
      }
      echo "</table>";
    }

    // Close the database connection
    mysqli_close($conn);
  } else {
    echo "<p>Please log in to view your bids.</p>";
  }
  ?>

  <div class="back-button">
    <a href="home.php">Back to Home</a>
  </div>
</body>
</html>
