<?php
// Include the database connection
include('connect.php'); // Your file with database connection details

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = $_POST['role']; // Default is 'user' if not set
    
    // Validate the data (Ensure passwords match and other basic checks)
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password before storing it in the database (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to insert the data
    // Use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" means the variable is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email is already registered!";
        exit;
    }

    // Insert data into the database using a prepared statement
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, role) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $hashedPassword, $role); // "sssss" means five string variables

    // Execute the query
    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>
