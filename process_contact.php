<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "travel_booking");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $ip = $_SERVER['REMOTE_ADDR'];

    // Insert into database
    $sql = "INSERT INTO contact_messages (name, email, message, ip_address) 
            VALUES ('$name', '$email', '$message', '$ip')";
    
    if ($conn->query($sql)) {
        $conn->close();
        // Show confirmation page
        show_confirmation();
        exit();
    } else {
        $conn->close();
        show_error();
        exit();
    }
}

// If not a POST request, show blank page
header("Location: contact.html");
exit();

function show_confirmation() {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Thank You!</title>
        <style>
            /* Your existing dark theme styles */
            body {
                font-family: 'Poppins', sans-serif;
                background: url('FINAL.jpg') no-repeat center center fixed;
                background-size: cover;
                color: white;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }
            .confirmation-box {
                background: rgba(0, 0, 0, 0.8);
                padding: 2rem;
                border-radius: 10px;
                text-align: center;
                max-width: 600px;
                width: 90%;
                border: 1px solid cyan;
                box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
            }
            .btn {
                background: cyan;
                color: black;
                padding: 12px 30px;
                border-radius: 25px;
                text-decoration: none;
                font-weight: bold;
                display: inline-block;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="confirmation-box">
            <h2>Message Received!</h2>
            <p>Thank you for contacting us. We'll get back to you soon.</p>
            <a href="contact.html" class="btn">Back to Contact</a>
        </div>
    </body>
    </html>
    <?php
}

function show_error() {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
        <!-- Same style as confirmation -->
    </head>
    <body>
        <div class="confirmation-box">
            <h2>Something Went Wrong</h2>
            <p>Please try again later.</p>
            <a href="contact.html" class="btn">Try Again</a>
        </div>
    </body>
    </html>
    <?php
}
?>