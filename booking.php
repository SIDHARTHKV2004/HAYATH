<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kerala Travel & Hotel Booking</title>
  <link rel="stylesheet" href="booked.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>
  
  <!-- HEADER -->
  <header class="navbar">
    <h2>HAYATH TRAVEL HUB</h2>
    <nav class="menu">
      <ul>
        <li><a href="MAIN PAGE.html">Home</a></li>
        <li><a href="DISTRICTS.html">Destinations</a></li>
        <li><a href="#">Gallery</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-text">
      <h1>Book Your Kerala Trip</h1>
      <p>Choose your destination and book your travel and hotel with ease.</p>
    </div>
  </section>

  <!-- BOOKING FORM SECTION -->
  <section class="booking-form">
    <h2>Travel & Hotel Booking</h2>
    <form action="process_booking.php" method="POST">
      <div class="form-group">
        <label for="from">From:</label>
        <select id="from" name="from" required>
            <option value="Thrissur">Thrissur</option>
            <option value="Kochi">Kochi</option>
            <option value="Munnar">Munnar</option>
            <option value="Alleppey">Alleppey</option>
            <option value="Thekkady">Thekkady</option>
            <option value="Varkala">Varkala</option>
          </select>
      </div>
      <div class="form-group">
        <label for="to">To:</label>
        <select id="to" name="to" onchange="updateFare()" required>
          <option value="Kochi">Kochi</option>
          <option value="Munnar">Munnar</option>
          <option value="Alleppey">Alleppey</option>
          <option value="Thekkady">Thekkady</option>
          <option value="Varkala">Varkala</option>
        </select>
      </div>
      <div class="form-group">
        <label for="date">Travel Date:</label>
        <input type="date" id="date" name="date" required>
      </div>
      <div class="form-group">
        <label for="time">Travel Time:</label>
        <input type="time" id="time" name="time" required>
      </div>
      <div class="form-group">
        <label for="vehicle">Travel Vehicle:</label>
        <select id="vehicle" name="vehicle" onchange="updateFare()" required>
          <option value="bus">Bus</option>
          <option value="train">Train</option>
          <option value="plane">Plane</option>
          <option value="car">Car</option>
        </select>
      </div>
      <div class="form-group">
        <label for="seating">Seating Option:</label>
        <select id="seating" name="seating" required>
          <option value="economy">Economy</option>
          <option value="business">Business</option>
          <option value="first">First Class</option>
        </select>
      </div>
      
      
      <!-- Hidden field to store calculated fare -->
      <input type="hidden" id="calculatedFare" name="fare" value="500">
      
      <div class="fare-display" id="fare">Estimated Fare: ₹500</div>
      
      <div id="status-message">
        <?php
          if (isset($_GET['status'])) {
            if ($_GET['status'] === 'success') {
              echo '<p style="color: green;">Booking saved successfully!</p>';
            } elseif ($_GET['status'] === 'error') {
              echo '<p style="color: red;">Error saving booking. Please try again.</p>';
            }
          }
        ?>
      </div>
      
      <button type="submit">Book Now</button>
    </form>
  </section>
  <!-- Confirmation Overlay -->
<div class="confirmation-overlay"></div>

<!-- Confirmation Box -->
<div id="booking-confirmation">
  <h3>Booking Confirmed! ✅</h3>
  <div class="confirmation-details">
    <!-- Dynamic content will be inserted by JavaScript -->
  </div>
  <button onclick="hideConfirmation()">Close</button>
</div>

  <!-- FOOTER -->
  <footer>
    <p>&copy; 2025 HAYATH TRAVEL HUB All rights reserved.</p>
  </footer>

  <script>
    const fareChart = {
      "Kochi": 500,
      "Munnar": 800,
      "Alleppey": 700,
      "Thekkady": 900,
      "Varkala": 850
    };

    const vehicleMultiplier = {
      "bus": 1,
      "train": 1.2,
      "plane": 2.5,
      "car": 1.5
    };

    function updateFare() {
      const to = document.getElementById("to").value;
      const vehicle = document.getElementById("vehicle").value;
      const baseFare = fareChart[to];
      const multiplier = vehicleMultiplier[vehicle];
      const totalFare = Math.round(baseFare * multiplier);
      
      // Update both display and hidden field
      document.getElementById("fare").textContent = "Estimated Fare: ₹" + totalFare;
      document.getElementById("calculatedFare").value = totalFare;
    }

    // Initialize fare calculation on page load
    document.addEventListener("DOMContentLoaded", function() {
      updateFare();
    });
  </script>
</body>
</html>