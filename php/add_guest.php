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

// Check if data is received via POST request
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['check_in_date']) && isset($_POST['check_out_date'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];

    // SQL query to insert the new guest into the database
    $sql = "INSERT INTO guests (first_name, last_name, email, phone, check_in_date, check_out_date, status) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$check_in_date', '$check_out_date', 'Checked In')";

    if ($conn->query($sql) === TRUE) {
        echo "New guest added successfully.";
    } else {
        echo "Error adding guest: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "All fields are required.";
}
?>
