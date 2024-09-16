<?php
 $host='localhost';
 $username='root';
 $password='';
 $db='bank_db';

 $connect= new mysqli($host, $username, $password, $db);
 if($connect){
    // echo json_decode('connection successful');
 }
 else{
    // echo json_decode('connection failed');
 }
?>
