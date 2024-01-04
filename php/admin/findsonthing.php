<?php

require '../partials/mongodbconnect.php';
use MongoDB\BSON\ObjectId;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

$matchId = isset($data['matchId']) ? new ObjectId($data['matchId']) : '';
$playerId = isset($data['playerId']) ? $data['playerId'] : '';

$matchfilter = ['_id' => $matchId,'player_id' => $playerId];

$findplayer = $matchCollection->findOne($matchfilter);

if($findplayer)
{
    $response = [
        'status_code' => '200',
        'message' => $findplayer
    ];
}
else{
    $response = [
        'status_code' => '404',
        'message' => 'database empty'
    ];
}

echo json_encode($response);
