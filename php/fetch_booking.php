<?php
// Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "indah_hotel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pull in your new columns too
$sql    = "SELECT id, guest_name, guest_email, check_in, check_out, guests, rooms 
           FROM bookings";
$result = $conn->query($sql);

// Build rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['guest_name'])  . "</td>
                <td>" . htmlspecialchars($row['guest_email']) . "</td>
                <td>" . $row['check_in']   . "</td>
                <td>" . $row['check_out']  . "</td>
                <td>" . $row['guests']     . "</td>
                <td>" . $row['rooms']      . "</td>
                <td>
                  <button class='btn btn-danger btn-sm' onclick='deleteBooking(" . $row['id'] . ")'>
                    <i class='fas fa-trash'></i> Delete
                  </button>
                </td>
              </tr>";
    }
} else {
    // colspan = total columns count (7)
    echo "<tr><td colspan='7'>No bookings found</td></tr>";
}

$conn->close();
?>
