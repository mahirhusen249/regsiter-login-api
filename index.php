<?php   
session_start();
include 'conn.php';  

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: POST');    
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods');   

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $name = $_POST['name'];   
    $mobileno = $_POST['mobileno'];   
    $email = $_POST['email'];   
    $password = $_POST['password'];    

    // Validation checks
    $errors = [];

    // Name validation (check if it's blank or less than 3 characters)   

    // if (empty($name) && empty($mobileno) && empty($email) && empty($password)) {
    //     $errors[] = "All fields are required.";
    // }
    if (empty($name)) {
        $errors[] = "Name is required.";
    } elseif (strlen($name) < 3) {
        $errors[] = "Name must be at least 3 characters.";
    }

   
    if (empty($mobileno)) {
        $errors[] = "Mobile number is required.";
    } elseif (!preg_match("/^\d{10}$/", $mobileno)) {
        $errors[] = "Mobile number must be 10 digits.";
    }

    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    
    if (!empty($errors)) {
        echo json_encode(array('message' => implode(", ", $errors), 'status' => false));
        exit; 
    }

    $password = md5($password);

    $sql = "INSERT INTO `api_tbl`(`name`, `mobileno`, `email`, `password`) VALUES ('$name', '$mobileno', '$email', '$password')";   
    $result = mysqli_query($conn, $sql);

    if ($result) {     
        echo json_encode(array('message' => 'Insert successful.', 'status' => true));    
    } else {    
        echo json_encode(array('message' => 'No record found.', 'status' => false));    
    }
}
?>
