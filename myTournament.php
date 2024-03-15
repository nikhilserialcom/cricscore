<?php
session_start();
require 'partials/mongodbconnect.php';
use MongoDB\BSON\ObjectId;

$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173/',
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

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

    $filter = ['userId' => $userId];
    $find_tor = $tournamentCollection->find($filter);
    $final_data = [];
    foreach($find_tor as $tor_data)
    {
        $tor_data['ground'] = $groundCollection->findOne(['_id' => new ObjectId($tor_data['ground'])]);
        $final_data[] = $tor_data;
    }

    if(!empty($final_data)){
        $response = array(
            'status_code' => 200,
            'torData' => $final_data
        );
    }
    else{
        $response = array(
            'status_code' => 200,
            'torData' => $final_data
        );
    }

}

echo json_encode($response,JSON_PRETTY_PRINT);