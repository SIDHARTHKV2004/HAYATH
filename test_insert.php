<?php
$conn = new mysqli("localhost", "root", "", "travel_booking");
$sql = "INSERT INTO bookings (from_location, to_location, travel_date, fare) 
        VALUES ('TEST', 'TEST', '2025-05-15', 500)";

if ($conn->query($sql)) {
    echo "✅ Test data inserted! Check phpMyAdmin.";
} else {
    echo "❌ Error: " . $conn->error;
}
$conn->close();
?>