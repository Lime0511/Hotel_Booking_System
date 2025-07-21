<?php
// Database connection settings (adjust accordingly)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "indah_hotel"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID is passed via GET request
if (isset($_GET['id'])) {
    $room_id = $_GET['id'];

    // SQL query to delete the room
    $sql = "DELETE FROM rooms WHERE id='$room_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Room deleted successfully.";
    } else {
        echo "Error deleting room: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
