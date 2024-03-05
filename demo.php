<?php

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

session_start();

$data = json_decode(file_get_contents('php://input'), true);
if(!isset($_SESSION['userId'])){
    $response = array(
        'status_code' => "400",
        'message' => "your session is expire"
    );
}else {
    $teamId = (isset($data['teamId'])) ? new ObjectId($data['teamId']) : '';

    $filter_team = ['_id' => $teamId];
    $find_team = $teamCollection->findOne($filter_team);

    if($find_team)
    {
        $response = array(
            'status_code' => "200",
            'team_data' => $find_team
        );
    }
    else{
        $response = array(
            'status_code' => "404",
            'message' => "team is not exist in database"
        );
    }
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>