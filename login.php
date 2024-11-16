<?php  
include 'conn.php'; 
session_start();

 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
    $email = $_POST['email'];
    $password = $_POST['password']; 

    
    $errors = [];

     
    if (empty($email)) {
        $errors[] = "Email is required.";
    }

     
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
 
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

     
    if (!empty($errors)) {
        echo json_encode(array('message' => implode(", ", $errors), 'status' => false));
        exit;
    }

    
    $query = "SELECT * FROM api_tbl WHERE email='$email' AND password=MD5('$password')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) { 
         
        $_SESSION['authenticated'] = true;
        $_SESSION['email'] = $email; 
        
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['id'];  

         
        $token = base64_encode($email . ':' . $user_id);  

        echo json_encode(array("message" => "Login successful", "status" => true, "token" => $token));

    } else {
        
        echo json_encode(array("message" => "Invalid credentials", "status" => false));
    }
}
?>  
