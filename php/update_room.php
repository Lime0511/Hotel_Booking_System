<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "indah_hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['id'];
    $price = $_POST['price'];
    $vacancy_status = $_POST['vacancy_status'];

    // SQL query to update the room
    $sql = "UPDATE rooms SET price='$price', vacancy_status='$vacancy_status' WHERE id='$room_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Room updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
