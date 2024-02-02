<?php 
session_start();
require 'partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173',
];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if (in_array($origin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");
header("ngrok-skip-browser-warning: 1");


if(isset($_SESSION['userId']))
{
    $userId = $_SESSION['userId'];
    $filter = ['_id' => $userId];
    $find_address = $userCollection->findOne($filter);
    $response = [
        'status_code' => "200",
        'address' => $find_address['address']
    ];
}
else{
    $response = [
        'status_code' => "400",
    ];
}
echo json_encode($response,JSON_PRETTY_PRINT);
?>