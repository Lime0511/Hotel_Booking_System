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
    $feedback_id = $_GET['id'];

    // SQL query to delete the feedback based on ID
    $sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {
        echo "Feedback deleted successfully!";
    } else {
        echo "Error deleting feedback: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "No feedback ID provided.";
}

// Close the connection
$conn->close();
?>
