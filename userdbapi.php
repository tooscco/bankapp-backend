<?php
// Start the session
// session_start();

// require 'connect.php';



// header("Access-Control-Allow-Origin:*");
// header("Access-COntrol-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// // Ensure the user is logged in by checking if customer_id exists in session
// if (!isset($_SESSION['customer_id'])) {
//     echo json_encode([
//         'status' => false,
//         'message' => 'User is not logged in. Please log in to view the dashboard.'
//     ]);
//     exit();
// }

// // Get customer_id from session
// $customer_id = $_SESSION['customer_id'];

// // Database connection (assuming you have this in 'connect.php')
// require 'connect.php';

// // Fetch user details using customer_id
// $query = "SELECT * FROM customer_table WHERE customer_id = ?";
// $stmt = $connect->prepare($query);
// $stmt->bind_param('i', $customer_id);
// $stmt->execute();
// $result = $stmt->get_result();

// // Check if user details were found
// if ($result->num_rows > 0) {
//     $user_details = $result->fetch_assoc();

//     // Output the user details as JSON (for AJAX or frontend display)
//     echo json_encode([
//         'status' => true,
//         'message' => 'User details retrieved successfully',
//         'data' => $user_details  // Full user data
//     ]);
// } else {
//     echo json_encode([
//         'status' => false,
//         'message' => 'User details not found.'
//     ]);
// }

// $stmt->close();
// $connect->close();


require 'connect.php';

// $_SESSION['firstname'];
// $id=$_SESSION['firstname'];

header("Access-Control-Allow-Origin:*");
header("Access-COntrol-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$id= $_SESSION['customer_id'];

$query="SELECT * FROM customer_table WHERE customer_id=?";
$dbcon=$connect->prepare($query);
$dbcon->bind_param('i', $id);
$dbcon->execute();
$dbresult=$dbcon->get_result();

if($dbresult ->num_rows > 0){
    $result=$dbresult->fetch_assoc();

    echo json_encode([
        'status' => true,
        'message' => 'Data retrieved successfully',
        'data' => $result
    ]);
}
else{
    echo json_encode([
        'status' => false,
        'message' => 'Failed to retrieve data'
    ]);
}
