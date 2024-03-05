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

    $matchFilter = ['userId' => $userId];
    $checkMatch = $matchCollection->find($matchFilter);

    $matches = [];

    foreach ($checkMatch as $match) {
        $teamAName = $teamCollection->findOne(['_id' => new ObjectId($match['teamA_id'])]);
        $teamBName = $teamCollection->findOne(['_id' => new ObjectId($match['teamB_id'])]);
        $match['teamA'] = $teamAName['teamName'];
        $match['teamB'] = $teamBName['teamName'];
        $matches[] = $match;
    }

    if (!empty($matches)) {
        $response = [
            'status_code' => 200,
            'matches' => $matches
        ];
    } else {
        $response = [
            'status_code' => "404",
            'userId' => $userId,
            'message' => 'No record found'
        ];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
