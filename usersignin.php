<?php 
require 'connect.php';

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:Content-Type");
header("Content-Type: application/json");

$input= json_decode(file_get_contents("php://input"));

if (!isset($input->emailOrUsername) || !isset($input->password)) {
    echo json_encode([
        'status' => false,
        'message' => 'Missing email/username or password.'
    ]);
    exit();
}

$password=$input->password;
$emailOrUsername=$input->emailOrUsername;

$query="SELECT * FROM customer_table WHERE (email= ? OR username= ?)";
$dncon=$connect->prepare($query);
$dncon->bind_param('ss', $emailOrUsername, $emailOrUsername);
$dncon->execute();
$result=$dncon->get_result();
if($result->num_rows>0){
    $user=$result->fetch_assoc();
    $_SESSION['customer_id'] = $user['customer_id'];
    $hashedpassword=$user['password'];
    $password_verify= password_verify($password, $hashedpassword);
    if(!$password_verify){
        $response=[
            'status'=> false,
            'message'=> 'Email/ Username or password is incorrect',
        ];
        echo json_encode($response);
    }
    else{
        $response=[
            'status'=> true,
            'message'=> 'Login successful',
            'user'=> $user,
        ];
        echo json_encode($response);
    }
}
else{
    $response=[
        'status'=> false,
        'message'=> 'Email/ Username or password is incorrect',
    ];
    echo json_encode($response);
}
?>