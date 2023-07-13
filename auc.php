<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if the user is logged in
  if (isset($_SESSION['username'])) {
    // Get the submitted bid details
    $item_name = $_POST['item_id'];
    $bidder_name = $_SESSION['username'];
    $bid_amount = $_POST['bid_amount'];

    // Connect to the database
    $host = 'localhost';
    $user = 'root';
    $password = ''; // Replace with your actual database password
    $database = 'project'; // Replace with your actual database name

    $conn = mysqli_connect($host, $user, $password, $database);
  	

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve the current highest bid for the item
	
    $current_bid_query = "SELECT MAX(bid_amount) AS current_bid FROM bids WHERE item_id='$item_name'";
    $current_bid_result = mysqli_query($conn, $current_bid_query);
    $current_bid_row = mysqli_fetch_assoc($current_bid_result);
    $current_bid = $current_bid_row['current_bid'];
	 $starting_bid_query = "SELECT starting_bid FROM items WHERE item_id='$item_name'";
    $starting_bid_result = mysqli_query($conn, $starting_bid_query);
    $starting_bid_row = mysqli_fetch_assoc($starting_bid_result);
    $starting_bid = $starting_bid_row['starting_bid'];
	 $winning_bid_query= "SELECT b.bid_amount AS max_bid,b.bidder_name FROM bids b WHERE b.item_id = '$item_name' AND b.bid_amount = (SELECT MAX(bid_amount) FROM bids WHERE item_id = '$item_name')";
     $winning_bid_result = mysqli_query($conn, $winning_bid_query);
     
if ($winning_bid_result && mysqli_num_rows($winning_bid_result) > 0) {
  $winning_bid_row = mysqli_fetch_assoc($winning_bid_result);
  $winning_bid = $winning_bid_row['max_bid'];
  $winning_bidder = $winning_bid_row['bidder_name'];
} else {
  $winning_bid = null;
  $winning_bidder = null;
} 
     $auction_end_time='2023-07-13 11:15:00';
    $current_time = time();
    $end_time = strtotime($auction_end_time);

    if ($current_time >= $end_time) {
      echo "<p>The auction has ended. No further bids are accepted.</p>";

    } else {
    // Check if the submitted bid is higher than the current highest bid or the starting price
    if ($bid_amount > $current_bid && $bid_amount > $starting_bid) {
      // Insert the new bid into the database
      $insert_query = "INSERT INTO bids (item_id, bidder_name, bid_amount) VALUES ('$item_name', '$bidder_name', '$bid_amount')";
      if (mysqli_query($conn, $insert_query)) {
        echo "<p>Your bid of ₹$bid_amount for item_id:$item_name has been successfully placed.</p>";
      } else {
        echo "<p>Failed to place the bid. Please try again.</p>";
      }
    } else {
      echo "<p>Your bid of ₹$bid_amount for item_id:$item_name is not higher than the current highest bid.</p>";
    }
    }
    // Close the database connection
    mysqli_close($conn);
  } else {
    echo "<p>Please log in to place a bid.</p>";
  }
} else {
  echo "<p>Invalid request.</p>";
}
?>
<?php

// AUCTION ITEM CLASS
class AuctionItem {
  public $id;
  public $name;
  public $description;
  public $starting_bid;
  public $current_bid;
  public $bids;
  public $end_time;
  

  public function __construct($id, $name, $starting_bid) {
    $this->id = $id; // Assign the item ID
    $this->name = $name;
    $this->current_bid = $starting_bid;
    $this->bids = [];
    $this->end_time = '2023-07-13 11:15:00';
  }

  public function is_auction_ended() {
    $current_time = time();
	$end_time = strtotime($this->end_time);
    return $current_time > $end_time;
  }

   public function getClosingTime() {
    return $this->end_time;
  }  
  public function __toString() {
    return "$this->name Auction\nStarting Bid: ₹$this->starting_bid\nEnd Time: $this->end_time\nDescription: $this->description";
  }

  public function place_bid($bidder_name, $bid_amount) {
    if ($bid_amount > $this->current_bid) {
     
      $this->current_bid = $bid_amount;
      $this->bids[] = [
      'bidder_name' => $bidder_name,
      'bid_amount' => $bid_amount
    ];
     

      return true;
    } else {
      return false;
    }
  }
   public function getBids() {
    return $this->bids;
}public function getWinningBid() {
    return $this->winning_bid;
      
      
    
    
  }
}
// AUCTION CLASS
class Auction {
  public $items;
  public $bidders;

  public function __construct() {
    $this->items = [];
    $this->bidders = [];
  }

  public function add_item($item) {
    $this->items[] = $item;
  }

  public function register_bidder($bidder_name) {
    $this->bidders[$bidder_name] = 1000; // Each bidder starts with $1000
  }
    public function insert_winner_details($item_name, $winning_bid, $winning_bidder) {
    $host = 'localhost';
    $user = 'root';
    $password = ''; // Replace with your actual database password
    $database = 'project'; // Replace with your actual database name

    $conn = mysqli_connect($host, $user, $password, $database);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $insert_winner_query = "INSERT INTO winners (item_id, bidder_name, bid_amount) VALUES ('$item_name', '$winning_bidder', '$winning_bid')";
    mysqli_query($conn, $insert_winner_query);

    // Close the database connection
    mysqli_close($conn);
  }


  public function find_item_by_name($name) {
  // Connect to the database
  $conn = mysqli_connect('localhost', 'root', '', 'project');

  // Prepare and execute the query to retrieve the item by name
  $query = "SELECT * FROM items WHERE item_id = '$name'";
  $result = mysqli_query($conn, $query);

  // Check if the item was found
  if (mysqli_num_rows($result) > 0) {
    // Fetch the item data from the result set
    $row = mysqli_fetch_assoc($result);

    // Create an AuctionItem object and populate its properties
    $item = new AuctionItem(
      $row['item_id'],
      $row['item_name'],
      $row['starting_bid']
    );

    // Close the database connection
    mysqli_close($conn);

    // Return the item object
    return $item;
  } else {
    // Item not found
    return null;
  }
}
 
  public function start_auction($item_name, $bidder_name, $bid_amount) {
    $item = $this->find_item_by_name($item_name);
    if ($item) {
      if (!array_key_exists($bidder_name, $this->bidders)) {
        echo "You need to register first!";
        return;
      }

      

     

      if ($item->is_auction_ended()) {
        echo "<br>Auction closed!<br>";

         $host = 'localhost';
    $user = 'root';
    $password = ''; // Replace with your actual database password
    $database = 'project'; // Replace with your actual database name

    $conn = mysqli_connect($host, $user, $password, $database);
  	

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
      $winning_bid_query ="SELECT b.bid_amount AS max_bid,b.bidder_name FROM bids b WHERE b.item_id = '$item_name' AND b.bid_amount = (SELECT MAX(bid_amount) FROM bids WHERE item_id = '$item_name')";

$winning_bid_result = mysqli_query($conn, $winning_bid_query);

if ($winning_bid_result && mysqli_num_rows($winning_bid_result) > 0) {
  $winning_bid_row = mysqli_fetch_assoc($winning_bid_result);
  $winning_bid = $winning_bid_row['max_bid'];
  $winning_bidder = $winning_bid_row['bidder_name'];
} else {
  $winning_bid = null;
  $winning_bidder = null;
}
 $bids_query = "SELECT bid_amount, bidder_name FROM bids WHERE item_id = '$item_name'";
$bids_result = mysqli_query($conn, $bids_query);
             
        echo "winning bid: ₹".$winning_bid; 

        if (mysqli_num_rows($bids_result) > 0) {
  echo "<br>Bids:";
  while ($bid_row = mysqli_fetch_assoc($bids_result)) {
    $bid_amount = $bid_row['bid_amount'];
    $bidder_name = $bid_row['bidder_name'];
    echo "<br>Bidder: $bidder_name, Amount: ₹$bid_amount";
  }
} 
     $winner_details_query = "SELECT * FROM winners WHERE item_id = '$item_name'";
      $winner_details_result = mysqli_query($conn, $winner_details_query);
		if (mysqli_num_rows($winner_details_result) == 0) {
        // Insert the winner details
        $this->insert_winner_details($item_name, $winning_bid, $winning_bidder);
      } 

        
       
          if ($winning_bid) {
            echo "<br>Winner: " . $winning_bid_row['bidder_name'] ;
            echo "\nWinning Price: ₹" . $winning_bid;
          }
         else {
          echo "\nNo bids were placed for this item.";
        }
      } else {
		  if ($bid_amount <= 0) {
        echo "Invalid input! Please enter a positive number";
        return;
      }

      if ($item->place_bid($bidder_name, $bid_amount) ) {
        echo "Bid accepted!";
      } else {
        echo "Your bid is not high enough!";
      }
        echo "<br>Auction is still ongoing.";
      }
    } else {
      echo "Item not found!";
    }
     echo "<br>Current Time: " . date('Y-m-d H:i:s');
  

    if ($item && $item->is_auction_ended()) {
      // Perform any necessary actions after the auction ends
    }
  } 
}

// MAIN CODE
$auction = new Auction();

// Add items to the auction
$item1 = new AuctionItem(1, "Guitar", "A Fender Stratocaster guitar", 5000);
$item2 = new AuctionItem(2, "Oppo Phone", "A brand new Oppo phone", 15000);
$item3 = new AuctionItem(3, "Paintings", "A collection of beautiful paintings", 25000);
$item4 = new AuctionItem(4, "Jersey", "Indian Cricket team all format jerseys", 100000);
$auction->add_item($item1);
$auction->add_item($item2);
$auction->add_item($item3);
$auction->add_item($item4);

// Register bidders
$auction->register_bidder($_SESSION['username']);

// Start the auction
$item_name = $_POST['item_id'];
$bidder_name = $_SESSION['username'];


$bid_amount = $_POST['bid_amount'];

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Auction Result</title>";
echo "<style>";
// CSS styles for the result page
echo "body {";
echo "  font-family: Arial, sans-serif;";
echo "  margin: 0;";
echo "  padding: 0;";
echo "  background-color: green;";
echo "font-size:24px;";
echo "}";

echo "header {";
echo "  background-color:green;";
echo "  padding: 20px;";
echo "  text-align: center;";
echo "}";
echo "h1 {";
echo "  margin: 0;";
echo "  color: #333;";
echo " font-size: 30px;";
echo "}";

echo "main {";
echo "  margin: 20px;";
echo "  background-color:green;";
echo "  text-align: center;";
echo "  font-size: 24px;";


echo "}";

echo ".center {";
echo "  display: flex;";
echo "  flex-direction: row;";
echo "  justify-content: center;";
echo "  margin-top: 20px;";
echo "}";
echo "button {";
echo "  background-color: #007bff;";
echo "  color: #fff;";
echo "  border: none;";
echo "  padding: 10px 20px;";
echo "  margin: 5px;";
echo "  border-radius: 5px;";
echo "  cursor: pointer;";
echo "}";
echo "button a {";
echo "  color: #fff;";
echo "  text-decoration: none;";
echo "}";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<header>";
echo "<h1>Auction Result</h1>";
echo "</header>";
echo "<main>";
$auction->start_auction($item_name, $bidder_name, $bid_amount);
// Retrieve the item from the auction
$item = $auction->find_item_by_name($item_name);

if ($item) {
  $closing_time = $item->getClosingTime();
  echo "<p>Auction will be closed on: $closing_time</p>";
}
echo "</main>";
echo "<div class='center'>";
echo "<div class='button'>";
echo "<button><a href='home.php'>Back to Home</a></button>";
echo "<button><a href='categories.php'>Back to Buy Items</a></button>";
echo "</div>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
