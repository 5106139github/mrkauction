<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Online Auction</title>
  <style>
  .hover-effect{
	  color:;
  }
  .hover-effect:hover{
	  color:red;
  }
    /* CSS styles for the entire page */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: grid;
      grid-template-rows: auto 1fr auto;
      min-height: 100vh;
	  background-image: url('bg.jpg');/* Replace 'background-image.jpg' with your image file path */
      background-size: cover;
    }

    /* CSS styles for the header section */
    header {
      background-color: #f2f2f2;
      padding: 20px;
      text-align: center;
      position: relative;
    }

    /* CSS styles for the navigation section */
    
    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
    }
    nav li {
      margin: 0 10px;
    }
    nav a {
      color: #333;
      text-decoration: none;
    }

    /* CSS styles for the content section */
    main {
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    /* CSS styles for the moving text */
    .moving-text {
      position: absolute;
      top: 50%;
      left: 100%;
      transform: translate(-50%, -50%);
      white-space: nowrap;
      color: green;
      font-size: 24px;
      animation: moveText 20s linear infinite;
    }

    @keyframes moveText {
      0% {
        left: 100%;
      }
      100% {
        left: -100%;
      }
    }

    /* CSS styles for the logo */
    .logo {
      position: absolute;
      top: 10px;
      right: 10px;
      max-width: 100px;
    }

    /* CSS styles for the footer section */
    footer {
      background-color: #f2f2f2;
      padding: 10px;
      text-align: center;
    }

  </style>
</head>
<body>
  <header>
    <img src="logo.png" alt="Online Auction Logo" class="logo">
    <h1 style="color: #ff6600;">Welcome to the Online Auction,<span id="username"><?php echo $username; ?></span>!</h1>
  </header>
  
  <nav>
    <ul>
      <li><a href="home.php"><p class="hover-effect">Home</p></a></li>
      <li><a href="browse.php"><p class="hover-effect">Browse Items</p></a></li>
      <li><a href="bids.php"><p class="hover-effect">My Bids</p></a></li>
      <li><a href="categories.php"><p class="hover-effect">Buy Items</p></a></li>
      <li><a href="account.php"><p class="hover-effect">My Account</p></a></li>
      <li><a href="login.php"><p class="hover-effect">Logout</p></a></li>
    </ul>
  </nav>

  <main>
    <div class="moving-text"><p class="hover-effect"> AUCTION BEYOND ACTION..!!</p></div>
    <!-- Content goes here -->
	
  </main>
  
  <footer>
    <p>&copy; 2023 Online Auction. All rights reserved.</p>
  </footer>
</body>
</html>
