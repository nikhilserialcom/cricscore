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
    $data = json_decode(file_get_contents('php://input'), true);

    $tournamentId = isset($data['torId']) ? new ObjectId($data['torId']) : '';
    $roundId = isset($data['roundId']) ? $data['roundId'] : '';

    $filter = ['_id' => $tournamentId];
    $check_tor = $tournamentCollection->findOne($filter);
    if ($check_tor) {
        if ($check_tor['userId'] == $_SESSION['userId']) {

            $response = array(
                'status_code' => 200,
                'message' => $check_tor
            );
        } else {
            $response = array(
                'status_code ' => 401,
                'message' => "This tournament does not allow you to update"
            );
        }
    } else {
        $response = array(
            'status_code' => 404,
            'message' => 'Such a tournament does not exist.'
        );
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
