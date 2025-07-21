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
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $vacancy_status = $_POST['vacancy_status'];

    // SQL query to insert a new room
    $sql = "INSERT INTO rooms (room_number, room_type, price, vacancy_status) 
            VALUES ('$room_number', '$room_type', '$price', '$vacancy_status')";

    if ($conn->query($sql) === TRUE) {
        echo "New room added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
