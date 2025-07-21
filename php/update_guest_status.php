<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "indah_hotel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID and status are passed via POST request
if (isset($_POST['id']) && isset($_POST['status'])) {
    $guest_id = $_POST['id'];
    $status = $_POST['status'];

    // SQL query to update the guest status
    $sql = "UPDATE guests SET status='$status' WHERE id='$guest_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Guest status updated successfully.";
    } else {
        echo "Error updating guest status: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid data.";
}
?>
