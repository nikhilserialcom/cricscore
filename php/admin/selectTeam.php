<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

use MongoDB\BSON\ObjectId as Oid;

session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $matchId = isset($data['matchId']) ? $data['matchId'] : '';
    $teamA = isset($data['teamA_id']) ? $data['teamA_id'] : '';
    $teamB = isset($data['teamB_id']) ? $data['teamB_id'] : '';


    $matchFilter = ['_id' => new Oid($matchId)];
    $checkMatch = $matchCollection->findOne($matchFilter);

    if ($checkMatch) {
        if ($teamA) {
            $document = [
                '$set' => [
                    'teamA' => $teamA,
                ]
            ];
        }
        if ($teamB) {
            $document = [
                '$set' => [
                    'teamB' => $teamB,
                ]
            ];
        }
        $updateMtach = $matchCollection->updateOne($matchFilter, $document);
        if ($updateMtach) {
            $response = [
                'status_code' => 200,
                'message' => 'team selected'
            ];
        } else {
            $response = array(
                'status_code' => '422',
                'match' => 'network error'
            );
        }
    } else {
        $response = [
            'status_code' => "404",
            'message' => 'record not found'
        ];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
