<?php
// bikes.php
require_once 'db_connect.php'; // Include the database connection

// Query to retrieve available bikes (assuming a 'bikes' table similar to 'cars')
$sql = "SELECT * FROM Bikes WHERE available = 1"; //  Adjust table and column names!
try {
    $stmt = $pdo->query($sql);
    $bikes = $stmt->fetchAll(); // Fetch all rows as an associative array
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Better error handling in production
    $bikes = []; // Set to an empty array on error
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bikes</title>
    <link rel="icon" type="image/png" href="images/wheelzonrent-logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="poppins.css" type="text/css" media="all">
    <link rel="stylesheet" href="montserrat.css" type="text/css" media="all">
    <link rel="stylesheet" href="bikes.css">  </head>
<body>
    <header>
        <div class="up" id="up">
            <div class="logo">
                <img src="images/wheelzonrent-logo.png" alt="Wheelzonrent Logo">
                <div class="contact-info">
                    <img src="images/phone.png" alt="Phone">
                    <span>+91-7380718141</span>
                    <img src="images/message.png" alt="Email">
                    <span>Info@wheelzonrent.in</span>
                </div>
            </div>
             <div class="logo1">
                <center><img  src="images/wheelzonrent-logo.png" height="50%" width="30%"></center>
                <div class="call"><img height="25%" width="2.5%" src="images/phone.png" style="height:auto;"><font>+91-7380718141 </font></div>
                <div class="mail"><img height="21%" width="2.5%" src="images/message.png" style="height:auto;"><font> Info@wheelzonrent.in</font></div>
            </div>
            <nav>
                <ul>
                    <li><a class="navi" href="Home.php">Home</a></li>
                    <li><a class="navi" href="cars.php">Cars</a></li>
                    <li><a class="active" href="bikes.php">Bikes</a></li>
                    <li>
                        <div class="dropdown">
                            <a class="navi" href="Home.php#service">Service</a>
                            <div class="dropdown-content">
                                <a href="rental.php">CAR RENTAL SERVICE</a>
                                <a href="corporate.php">CORPORATE CAR RENTAL</a>
                                <a href="wed.php">WEDDING CAR RENTAL</a>
                                <a href="event.php">EVENT TRANSPORTATION</a>
                                <a href="self.php">SELFDRIVE CAR RENTAL</a>
                                <a href="one.php">ONE WAY DROP SERVICE</a>
                            </div>
                        </div>
                    </li>
                    <li><a class="navi" href="contact.php">Contact Us</a></li>
                    <li><a class="navi" href="terms.php">Terms</a></li>
                    <li><a class="navi" href="feedback.php">Feedback</a></li>
                </ul>
            </nav>
        </div>

        <div class="head">
            <h1>FEATURED BIKES</h1>
			 <hr width="10%" color="white" style="margin-left:36%">
            <svg height="2.2vw" width="2.2vw" viewBox="0 0 200 200">
				<polygon points="100,10 40,198 190,78 10,78 160,198">
				</svg>
				<hr width="10%" color="white" style="margin:-1.15% 0 0 54%">
            <br>
            <font>It`s Not A Race, It`s Journey Enjoy The Moment!</font>
        </div>
    </header>

    <main class="bike-listings">
      <?php foreach ($bikes as $bike): ?>
        <div class="bike-item">
            <img src="<?php echo htmlspecialchars($bike['image_url']); ?>" alt="<?php echo htmlspecialchars($bike['make'] . ' ' . $bike['model']); ?>">
            <h2><?php echo htmlspecialchars($bike['make'] . ' ' . $bike['model']); ?></h2>
            <p>Mileage: <?php echo htmlspecialchars($bike['mileage']); ?></p>  
            <p>Rs<?php echo htmlspecialchars(number_format($bike['daily_rate'], 2)); ?>/- per day</p>
           <form action="contact.php" method="post">
                <input type="hidden" name="bike_id" value="<?php echo htmlspecialchars($bike['bike_id']); ?>">
                <input type="hidden" name="bike_name" value="<?php echo htmlspecialchars($bike['make'] . ' ' . $bike['model']); ?>">
                <input type="hidden" name="daily_rate" value="<?php echo htmlspecialchars($bike['daily_rate']); ?>">
                <button type="submit" class="book-now">BOOK NOW</button>
            </form>
        </div>
    <?php endforeach; ?>
    </main>

    <footer>
        <img class="service" src="images/service.jpg" alt="Our Services">
        <div class="footer-content">
            <div class="widget">
                <h3>About Us</h3>
                <p class="text">Showtime is one of the reputed Travel Company in India. At Showtime everything we do is about giving you the freedom to discover more.</p>
            </div>
            <div class="widget">
                <h3>Contact Info</h3>
                <p class="text1">Address: Jaunpur ,Uttar Pradesh,India<br>
                    <img src="images/phone.png" alt="Phone"> +91-7380718141<br>
                    <img src="images/message.png" alt="Email"> singh.anubhav3945@gmail.com
                </p>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright 2025 All Right Reserved</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>