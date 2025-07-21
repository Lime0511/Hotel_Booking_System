<?php
// Include the database connection
include('connect.php'); 

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $feedback = htmlspecialchars(trim($_POST['feedback']));

    // Basic validation (check if fields are empty)
    if (empty($name) || empty($email) || empty($feedback)) {
        header("Location: user.html"); // Redirect if validation fails (optional)
        exit;
    }

    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: user.html"); // Redirect if email is invalid (optional)
        exit;
    }

    // Insert feedback into database
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $feedback); // "sss" means three string variables
    
    if ($stmt->execute()) {
        // Redirect to user.php without any message
        header("Location: user.html");
        exit;  // Stop further script execution after redirect
    } else {
        header("Location: user.html");
        exit;
    }

    // Close the statement
    $stmt->close();
}
?>
