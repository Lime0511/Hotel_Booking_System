<?php
// Include the database connection
include('connect.php');
session_start();

// Initialize response array
$response = array('success' => false, 'message' => '', 'redirect' => '');

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input to prevent XSS
    $email = htmlspecialchars(trim($email));
    
    // Prepare the SQL statement to check if the user exists
    $stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" means the email is a string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];  // Store the role for redirection

            // Set success response and the redirect URL
            $response['success'] = true;
            $response['message'] = 'Login successful!';
            
            // Redirect based on user role
            if ($user['role'] == 'admin') {
                $response['redirect'] = 'admin.html';  // Admin Dashboard
            } else {
                $response['redirect'] = 'user.html';  // User Dashboard
            }
        } else {
            $response['message'] = 'Incorrect password!';
        }
    } else {
        $response['message'] = 'No user found with that email!';
    }
}

// Return response as JSON
echo json_encode($response);
?>
