<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "indah_hotel";

// Get the booking ID from the query string
$bookingId = $_GET['id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete query to remove the booking
$sql = "DELETE FROM bookings WHERE id = $bookingId";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Booking deleted successfully.";
} else {
    echo "Error deleting booking: " . $conn->error;
}

$conn->close();
?>
