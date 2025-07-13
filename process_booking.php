<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "travel_booking");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Calculate fare
    $fareChart = ["Kochi" => 500, "Munnar" => 800, "Alleppey" => 700, "Thekkady" => 900, "Varkala" => 850];
    $vehicleMultiplier = ["bus" => 1, "train" => 1.2, "plane" => 2.5, "car" => 1.5];
    $fare = round($fareChart[$_POST['to']] * $vehicleMultiplier[$_POST['vehicle']]);

    // Insert into database
    $sql = "INSERT INTO bookings (
        from_location, 
        to_location, 
        travel_date, 
        travel_time, 
        vehicle_type, 
        seating_option, 
        fare
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssd",
        $_POST['from'],
        $_POST['to'],
        $_POST['date'],
        $_POST['time'],
        $_POST['vehicle'],
        $_POST['seating'],
        $fare
    );

    if ($stmt->execute()) {
        $booking_id = $conn->insert_id;
        $status = "success";
        $message = "Booking confirmed! Reference ID: $booking_id";
    } else {
        $status = "error";
        $message = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation | HAYATH TRAVEL HUB</title>
    <style>
        /* ===== YOUR EXACT STYLE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        body {
            background: url('FINAL.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .confirmation-wrapper {
            width: 100%;
            max-width: 800px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.3);
            border: 1px solid cyan;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .confirmation-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .confirmation-header h2 {
            font-size: 32px;
            color: cyan;
            margin-bottom: 10px;
        }
        
        .confirmation-icon {
            font-size: 60px;
            color: cyan;
            margin-bottom: 20px;
            animation: bounce 1s;
        }
        
        .confirmation-details {
            background: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .confirmation-details p {
            margin: 15px 0;
            font-size: 18px;
            display: flex;
        }
        
        .confirmation-details strong {
            color: cyan;
            min-width: 150px;
            display: inline-block;
        }
        
        .btn-cyan {
            background: cyan;
            color: black;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
        }
        
        .btn-cyan:hover {
            background: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 255, 255, 0.4);
        }
        
        .error-message {
            color: #ff6b6b;
            background: rgba(255, 0, 0, 0.1);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ff6b6b;
            margin-bottom: 20px;
        }
        
        /* YOUR ANIMATIONS */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }
    </style>
</head>
<body>
    <div class="confirmation-wrapper">
        <div class="confirmation-header">
            <div class="confirmation-icon">✓</div>
            <h2>Booking Confirmation</h2>
            <?php if(isset($status)): ?>
                <p><?php echo $status === 'success' ? 'Your trip has been booked successfully!' : 'There was an issue with your booking'; ?></p>
            <?php endif; ?>
        </div>
        
        <?php if(isset($status) && $status === 'success'): ?>
            <div class="confirmation-details">
                <p><strong>Reference ID:</strong> <?php echo $booking_id; ?></p>
                <p><strong>From:</strong> <?php echo htmlspecialchars($_POST['from']); ?></p>
                <p><strong>To:</strong> <?php echo htmlspecialchars($_POST['to']); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($_POST['date']); ?></p>
                <p><strong>Time:</strong> <?php echo htmlspecialchars($_POST['time']); ?></p>
                <p><strong>Vehicle:</strong> <?php echo htmlspecialchars($_POST['vehicle']); ?></p>
                <p><strong>Seating:</strong> <?php echo htmlspecialchars($_POST['seating']); ?></p>
                <p><strong>Total Fare:</strong> ₹<?php echo $fare; ?></p>
            </div>
            
            <div style="text-align: center;">
                <a href="booking.php" class="btn-cyan">Book Another Trip</a>
            </div>
            
        <?php elseif(isset($status)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <div style="text-align: center;">
                <a href="booking.php" class="btn-cyan">Try Again</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>