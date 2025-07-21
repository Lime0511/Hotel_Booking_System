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

// Query to get guests from the database
$sql = "SELECT id, first_name, last_name, email, phone, check_in_date, check_out_date, status FROM guests";
$result = $conn->query($sql);

// Initialize an empty array for the guest data
$guestData = [];

if ($result->num_rows > 0) {
    // Fetch the data
    while ($row = $result->fetch_assoc()) {
        $guestData[] = $row;
    }
    // Return the guest data as JSON
    echo json_encode($guestData);
} else {
    // Return an empty array if no guests found
    echo json_encode([]);
}

// Close connection
$conn->close();
?>
