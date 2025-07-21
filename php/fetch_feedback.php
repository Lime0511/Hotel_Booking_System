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

// Query to get feedback from the database
$sql = "SELECT id, name, email, feedback, created_at FROM feedback";
$result = $conn->query($sql);

// Check if query execution is successful
if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Initialize an empty array for the feedback data
$feedbackData = [];

if ($result->num_rows > 0) {
    // Fetch the data
    while ($row = $result->fetch_assoc()) {
        $feedbackData[] = $row;
    }
    // Return the feedback data as JSON
    echo json_encode($feedbackData);
} else {
    // Return an empty array if no feedback found
    echo json_encode([]);
}

// Close connection
$conn->close();
?>
