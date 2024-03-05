<?php

session_start();

require '../partials/mongodbconnect.php';
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

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($_SESSION['userId']))
{
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
}
else{
    $playerId = isset($data['playerId']) ? $data['playerId'] : '';
    $batting_style = isset($data['battingStyle']) ? $data['battingStyle'] : '';
    $bowlingStyle = isset($data['bowlingStyle']) ? $data['bowlingStyle'] : '';

    $filter = ['_id' => new ObjectId($playerId)];
    $check_player = $userCollection->findOne($filter);

    if($check_player){
        $set_playing_style = [
            '$set' => [
                'battingStyle' => !empty($batting_style) ? $batting_style : $check_player['battingStyle'],
                'bowlingStyle' => !empty($bowlingStyle) ? $bowlingStyle : $check_player['bowlingStyle']
            ]
        ];

        $update_data = $userCollection->updateOne($filter,$set_playing_style);
        if($update_data){
            $response = array(
                'status_code' => "200",
                'message' => "set playing style successfully"
            );
        }
    }
    else{
        $response = array(
            'status_code' => "400",
            'message' => "user not found"
        );
    }
}
echo json_encode($response,JSON_PRETTY_PRINT);