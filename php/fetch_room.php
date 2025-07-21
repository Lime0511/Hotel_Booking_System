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

// Query to get rooms from the database
$sql = "SELECT id, room_number, room_type, price, vacancy_status FROM rooms";
$result = $conn->query($sql);

// Initialize an empty array for the room data
$roomData = [];

if ($result->num_rows > 0) {
    // Fetch the data
    while ($row = $result->fetch_assoc()) {
        $roomData[] = $row;
    }
    // Return the room data as JSON
    echo json_encode($roomData);
} else {
    // Return an empty array if no rooms found
    echo json_encode([]);
}

// Close connection
$conn->close();
?>
