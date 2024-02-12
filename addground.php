<?php
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

session_start();

if(!isset($_SESSION['userId'])){
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
}
else{
    
    $data = json_decode(file_get_contents('php://input'),true);
    
    $groundName =isset($data['ground_name']) ? $data['ground_name'] : '';
    $state = isset($data['state_name']) ? $data['state_name'] : '';
    $city = $data['city_name'];
    
    $document = [
        'groundName' => $groundName,
        'stateName' => $state,
        'cityName' => $city
    ];
    
    $addground = $groundCollection->insertOne($document);
    
    if($addground->getInsertedCount() > 0)
    {
        $response = array(
            'status_code' => '200',
            'message' => 'ground added successfully'
        );
    }
    else
    {
        $response = array(
            'status_code' => '500',
            'message' => 'somthing went to worng'
        );
    }
}

echo json_encode($response);
?>