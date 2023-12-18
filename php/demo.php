<?php 
require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

if(isset($_SESSION['userId']))
{
    $response = [
        'status_code' => "200",
        'message' => $_SESSION['userId']
    ];
}
else
{
    
    $response = [
        'status_code' => "400",
        'message' => "your session is expire"
    ];
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>