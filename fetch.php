<?php
include 'conn.php';  // Database connection
session_start();

// Get the token from the GET request
if (isset($_GET['token'])) {
    $token = $_GET['token'];

     $decoded = base64_decode($token);
    
     list($email, $user_id) = explode(':', $decoded);

     $query = "SELECT * FROM api_tbl WHERE email='$email' AND id='$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
         $user = mysqli_fetch_assoc($result);
        
         $_SESSION['authenticated'] = true;
        $_SESSION['email'] = $email;

         $data = array(
            "user_id" => $user['id'],
            "email" => $user['email'],
            "name" => $user['name']
        );

         echo json_encode(array("status" => true, "data" => $data));
    } else {
         echo json_encode(array("status" => false, "message" => "Invalid token or user not found"));
    }
} else {
     
    echo json_encode(array("status" => false, "message" => "Token is required"));
}
?>
