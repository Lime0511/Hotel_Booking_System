<?php
// Database connection settings
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
?>
