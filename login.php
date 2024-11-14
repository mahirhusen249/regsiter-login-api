<?php  
include 'conn.php'; 
session_start();

// Simulating login process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and password from the request
    $email = $_POST['email'];
    $password = $_POST['password']; // Ensure you are hashing the password in insert as well

    // Query to check user credentials
    $query = "SELECT * FROM api_tbl WHERE email='$email' AND password=MD5('$password')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) { 
        // If user found, set session variables
        $_SESSION['authenticated'] = true;
        $_SESSION['email'] = $email; 
        
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['id'];  // Get user ID from the database

        // Create a simple custom token (you can improve security with proper JWT or encryption)
        $token = base64_encode($email . ':' . $user_id);  // Encode email and user_id for the example

        echo json_encode(array("message" => "Login successful", "status" => true, "token" => $token));
    } else {
        // Invalid credentials
        echo json_encode(array("message" => "Invalid credentials", "status" => false));
    }
}
?>
