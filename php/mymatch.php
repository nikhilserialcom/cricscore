<?php
session_start();

require 'partials/mongodbconnect.php';

use MongoDB\BSON\ObjectId;

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");


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
        $match['teamA_id'] = $teamAName['teamName'];
        $match['teamB_id'] = $teamBName['teamName'];
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
            'message' => 'No record found'
        ];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
