<!DOCTYPE html>
<html>
<head>
  <title>Online Auction</title>
  <style>
    /* CSS styles for the home page */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
    }
    header {
      background-color: #f2f2f2;
      padding: 20px;
      text-align: center;
    }
    h1 {
      margin: 0;
      color: #333;
    }
    main {
      margin: 20px;
      text-align: center;
    }
    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }
    .item {
      width: 300px;
      margin: 10px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .item img {
      width: 200px;
      height: 200px;
      margin-bottom: 10px;
    }
    .item h2 {
      margin-top: 0;
      color: #333;
    }
    .item p {
      color: #777;
    }
    button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    button a {
      color: #fff;
      text-decoration: none;
    }
    .center {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Online Auction</h1>
  </header>
  <main>
    <h2>Featured Items</h2>
    <div class="container">
      <div class="item">
        <img src="Guitar.jpg" alt="Item 1">
        <h2>Item 1</h2>
        <p>A Fender Stratocaster guitar.</p>
        <?php
        // Connect to the database
        $host = 'localhost';
        $user = 'root';
        $password = ''; // Replace with your actual database password
        $database = 'project'; // Replace with your actual database name

        $conn = mysqli_connect($host, $user, $password, $database);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve current bid or starting price for Item 1 from the database
        $item1_query = "SELECT MAX(bid_amount) AS current_bid FROM bids WHERE item_id=1";
        $item1_result = mysqli_query($conn, $item1_query);
        $item1_row = mysqli_fetch_assoc($item1_result);
        $current_bid1 = $item1_row['current_bid'];

        if ($current_bid1 === null) {
          // No current bid, display the starting price
          $starting_price1 = 5000; // Replace with the actual starting price for Item 1
          echo "<p>Starting price: ₹$starting_price1</p>";
        } else {
          echo "<p>Current bid: ₹$current_bid1</p>";
        }

        mysqli_free_result($item1_result); // Free the result set
        ?>
        <form action="auc.php" method="POST">
          <input type="hidden" name="item_id" value="1">
          <input type="number" name="bid_amount" placeholder="Enter your bid amount" required>
          <input type="submit" value="Bid Now">
        </form>
      </div>

      <div class="item">
        <img src="Mobile.jpg" alt="Item 2">
        <h2>Oppo Phone</h2>
        <p>A brand new Oppo phone.</p>
        <?php
        // Retrieve current bid or starting price for Item 2 from the database
        $item2_query = "SELECT MAX(bid_amount) AS current_bid FROM bids WHERE item_id=2";
        $item2_result = mysqli_query($conn, $item2_query);
        $item2_row = mysqli_fetch_assoc($item2_result);
        $current_bid2 = $item2_row['current_bid'];

        if ($current_bid2 === null) {
          // No current bid, display the starting price
          $starting_price2 = 15000; // Replace with the actual starting price for Item 2
          echo "<p>Starting price: ₹$starting_price2</p>";
        } else {
          echo "<p>Current bid: ₹$current_bid2</p>";
        }

        mysqli_free_result($item2_result); // Free the result set
        ?>
        <form action="auc.php" method="POST">
          <input type="hidden" name="item_id" value="2">
          <input type="number" name="bid_amount" placeholder="Enter your bid amount" required>
          <input type="submit" value="Bid Now">
        </form>
      </div>

      <div class="item">
        <img src="Paintings.jpg" alt="Item 3">
        <h2>Paintings</h2>
        <p>A collection of beautiful painting.</p>
        <?php
        // Retrieve current bid or starting price for Item 3 from the database
        $item3_query = "SELECT MAX(bid_amount) AS current_bid FROM bids WHERE item_id=3";
        $item3_result = mysqli_query($conn, $item3_query);
        $item3_row = mysqli_fetch_assoc($item3_result);
        $current_bid3 = $item3_row['current_bid'];

        if ($current_bid3 === null) {
          // No current bid, display the starting price
          $starting_price3 = 25000; // Replace with the actual starting price for Item 3
          echo "<p>Starting price: ₹$starting_price3</p>";
        } else {
          echo "<p>Current bid: ₹$current_bid3</p>";
        }

        mysqli_free_result($item3_result); // Free the result set

      
        ?>
        <form action="auc.php" method="POST">
          <input type="hidden" name="item_id" value="3">
          <input type="number" name="bid_amount" placeholder="Enter your bid amount" required>
          <input type="submit" value="Bid Now">
        </form>
      </div>
	  <div class="item">
        <img src="jersey.jpg" alt="Item 4">
        <h2>Jersey</h2>
        <p>Indian Cricket team all format jerseys.</p>
        <?php
        // Retrieve current bid or starting price for Item 4 from the database
        $item4_query = "SELECT MAX(bid_amount) AS current_bid FROM bids WHERE item_id=4";
        $item4_result = mysqli_query($conn, $item4_query);
        $item4_row = mysqli_fetch_assoc($item4_result);
        $current_bid4 = $item4_row['current_bid'];

        if ($current_bid4 === null) {
          // No current bid, display the starting price
          $starting_price4 = 100000; // Replace with the actual starting price for Item 3
          echo "<p>Starting price: ₹$starting_price4</p>";
        } else {
          echo "<p>Current bid: ₹$current_bid4</p>";
        }

        mysqli_free_result($item4_result); // Free the result set

        mysqli_close($conn); // Close the database connection
        ?>
        <form action="auc.php" method="POST">
          <input type="hidden" name="item_id" value="4">
          <input type="number" name="bid_amount" placeholder="Enter your bid amount" required>
          <input type="submit" value="Bid Now">
        </form>
      </div>
      <!-- Add more items here -->
    </div>
  </main>
  <div class="center">
    <button><a href="home.php">BACK TO HOME</a></button>
  </div>
</body>
</html>
