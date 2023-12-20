<?php 
require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

if(isset($_SESSION['userId']))
{
    session_destroy();
    // session_unset($_SESSION['userId']);
    $response = [
        'status_code' => "200",
        'message' => 'Logout successful! '
    ];
}
else{
    $response = [
        'status_code' => "400",
        'message' => 'ERROR:'
    ];
}
echo json_encode($response,JSON_PRETTY_PRINT);
?>