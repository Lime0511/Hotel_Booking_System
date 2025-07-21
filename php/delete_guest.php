<?php
// Database connection settings
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
    $guest_id = $_GET['id'];

    // SQL query to delete the guest
    $sql = "DELETE FROM guests WHERE id='$guest_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Guest deleted successfully.";
    } else {
        echo "Error deleting guest: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
