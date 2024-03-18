<?php
session_start();
require 'partials/mongodbconnect.php';
use MongoDB\BSON\ObjectId;

$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.26:5173/',
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

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $torId = isset($data['torId']) ? new  ObjectId($data['torId']) : '';

    $filter = ['_id' => $torId];
    $find_tor = $tournamentCollection->findOne($filter);

    if($find_tor){
        if(isset($find_tor['groups'])){
            $response = array(
                'status_code' => 200,
                'torData' => $find_tor['groups']
            );
        }
        else{
            $response = array(
                'status_code' => 200,
                'torData' => []
            );
        }
    }
    else{
        $response = array(
            'status_code' => 404,
            'message' => "database empty"
        );
    }

}

echo json_encode($response,JSON_PRETTY_PRINT);