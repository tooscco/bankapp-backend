<?php 
require 'connect.php';
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:Content-Type");
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"));

$surname = $input->surname;
$firstname = $input->firstname;
$lastname = $input->lastname;
$username = $input->username;
$email = $input->email;
$pnumber = $input->pnumber;
$address = $input->address;
$password = $input->password;
$gender = $input->gender;
$bdate = $input->bdate;
$checked = $input->checkbox;

// $results = ['status' => true];


$queryEmail = "SELECT * FROM `customer_table` WHERE email=?";
$dbpro = $connect->prepare($queryEmail);
$dbpro->bind_param('s', $email);
$dbpro->execute();
$emailResult = $dbpro->get_result();

if ($emailResult->num_rows > 0) {
    $results['status'] = false;  
    $results['emailMessage'] = 'Email already exists';
}


$queryUsername = "SELECT * FROM `customer_table` WHERE username=?";
$dbpro = $connect->prepare($queryUsername);
$dbpro->bind_param('s', $username);
$dbpro->execute();
$usernameResult = $dbpro->get_result();

if ($usernameResult->num_rows > 0) {
    $results['status'] = false;  
    $results['usernameMessage'] = 'Username already exists';
}
$queryPhone = "SELECT * FROM `customer_table` WHERE phonenumber=?";
$dbpro = $connect->prepare($queryPhone);
$dbpro->bind_param('s', $pnumber);
$dbpro->execute();
$phoneResult = $dbpro->get_result();

if ($phoneResult->num_rows > 0) {
    $results['status'] = false;  
    $results['phoneMessage'] = 'Phone number already exists';
}


if ($results['status'] === true) {
    $hashedpass = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO `customer_table` (`surname`,`firstname`,`lastname`,`username`,`email`,`password`,`address`,`gender`,`bdate`,`phonenumber`,`checked`) 
              VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $dbcon = $connect->prepare($query);
    $dbcon->bind_param('sssssssssss', $surname, $firstname, $lastname, $username, $email, $hashedpass, $address, $gender, $bdate, $pnumber, $checked);
    $dbcon->execute();
    $results['message'] = 'Signup successful';
}

if ($results['status'] === false) {
    unset($results['message']); 
}

echo json_encode($results); 
?>
