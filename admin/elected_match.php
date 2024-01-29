<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

$matchId = isset($data['matchId']) ? new MongoDB\BSON\ObjectId($data['matchId']) : '';
$teamId = isset($data['teamId']) ? new MongoDB\BSON\ObjectId($data['teamId']) : '';
$toss_elected = isset($data['elected']) ? $data['elected'] : '';

$check_match  = $matchCollection->findOne(['_id' => $matchId]);

if($check_match)
{
    $check_team = $teamCollection->findOne(['_id' => $teamId]);
    $document = [
        '$set' => [
            'won_toss' => $check_team['teamName'],
            'elected' => $toss_elected
        ]
    ];

    $update_match = $matchCollection->updateOne(['_id' => $matchId],$document);
    if($update_match){
        $response = [
            'status_code' => '200',
            'message' => $check_match,
        ];
    }
    else{
        $response = [
            'status_code' => '200',
            'message' =>'match update failed',
        ];
    }
}
else{
    $response = [
        'status_code' => "404",
        'message' => "database empty"
    ];
}

echo json_encode($response,JSON_PRETTY_PRINT);