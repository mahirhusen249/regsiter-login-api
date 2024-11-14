<?php  
include  'conn.php';  
  
header('content-type:application/json');
header('Access-Control-Allow-Origin: *');  
header('Access-control-allow-method:POST');    
header('Access-control-allow-header:Access-control-allow-header,content-type,Access-control-allow-method');   

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
$name=$_POST['name'];   
$mobileno=$_POST['mobileno'];   
$email=$_POST['email'];   
$password=md5($_POST['password']);    

$sql="INSERT INTO `api_tbl`(`name`,`mobileno`,`email`,`password`) VALUE ('$name','$mobileno','$email','$password')";   
$result=mysqli_query($conn,$sql);

if(mysqli_query($conn,$sql)){     

    echo json_encode(array('message'=>'insert successfully.','status'=>true));    
}        
else{    
    echo json_encode(array('message'=>'no record found.','status'=>false));    

}
}




?>