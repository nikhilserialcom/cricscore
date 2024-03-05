<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

use MongoDB\BSON\ObjectId;

session_start();

$data = json_decode(file_get_contents('php://input'), true);

$matchId = isset($data['matchId']) ? new ObjectId($data['matchId']) : '';
$teamId = isset($data['teamId']) ?  $data['teamId'] : '';
$playerId = isset($data['playerId']) ? $data['playerId'] : '';

$finalId = [];

foreach ($playerId as $id) {
    $addplayer = [
        'player_id' =>$id,
        'batting' => [
            'runs' => 0,
            'ball' => 0,
            'four' => 0,
            'six' => 0,
            'strikeRate' => 0,
            'batStatus' => "not out"
        ],
        'bowling' => [
            'runs' => 0,
            'over' => 0,
            'wicket' => 0,
            'economy' => 0,
            'maidenOver' => 0,
            'wideBall' => 0,
            'noBall' => 0,
            'extra' => [
                'W' => 0,
                'NB' => 0,
            ]
        ],
        'filder' => [
            'misRun' => 0,
            'saveRun' => 0,
            'dropCatch' => 0,
            'catch' => 0,
        ] 
        
    ];
    $finalId[] = $addplayer;
}

// $response = array(
//     'match_id' => $matchId,
//     'teamId' => $teamId,
//     'new_batsman_id' => $finalId,
// );

$matchFilter = ['_id' => $matchId];
$checkMatch = $matchCollection->findOne($matchFilter);

if ($checkMatch) {
    if ($checkMatch['team1_id'] == $teamId) {
        $update = [
            '$push' => [
                'team_1' => ['$each' => $finalId],
            ]
        ];
    } elseif ($checkMatch['team2_id'] == $teamId) {
        $update = [
            '$push' => [
                'team_2' =>  ['$each' => $finalId],
            ]
        ];
    }
    $updatePlayer = $matchCollection->updateOne($matchFilter, $update);
    if ($updatePlayer->getModifiedCount() > 0) {
        $response = array(
            'status_code' => '200',
            'match' => 'add player successfully'
        );
    } else {
        $response = array(
            'status_code' => '422',
            'match' => 'network error'
        );
    }
} else {
    $response = array(
        'status_code' => '400'
    );
}


echo json_encode($response);
