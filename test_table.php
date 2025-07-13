<?php
$conn = new mysqli("localhost", "root", "", "travel_booking");
$result = $conn->query("SHOW CREATE TABLE bookings");
if ($result) {
    echo "<pre>";
    print_r($result->fetch_assoc());
    echo "</pre>";
} else {
    echo "❌ Error: " . $conn->error;
}
$conn->close();
?>