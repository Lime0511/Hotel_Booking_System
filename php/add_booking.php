<?php
// Database connection (replace with your own creds)
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "indah_hotel";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1) Grab & sanitize the new fields
    $guest_name  = $conn->real_escape_string($_POST['guest_name']);
    $guest_email = $conn->real_escape_string($_POST['guest_email']);

    // 2) Your existing fields
    $check_in    = $conn->real_escape_string($_POST['check_in']);
    $check_out   = $conn->real_escape_string($_POST['check_out']);
    $guests      = (int) $_POST['guests'];
    $rooms       = (int) $_POST['rooms'];

    // 3) Insert with the full column list
    $sql = "
      INSERT INTO bookings 
        (guest_name, guest_email, check_in, check_out, guests, rooms)
      VALUES 
        ('$guest_name', '$guest_email', '$check_in', '$check_out', $guests, $rooms)
    ";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to your bookings page
        header("Location: user.html");
        exit; 
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
