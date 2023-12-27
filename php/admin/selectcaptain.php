<?php

require '../partials/mongodbconnect.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");


$data = json_decode(file_get_contents('php://input'), true);

$matchId = isset($data['matchId']) ? $data['matchId'] : '';
$teamId = isset($data['teamId']) ? $data['teamId'] : '';
$playerId = isset($data['playerId']) ? $data['playerId'] : '';
$playerRole = isset($data['role']) ? $data['role'] : '';

$playerFilter = [
    '_id' => new MongoDB\BSON\ObjectId($matchId),
];

$check_player = $matchCollection->findOne($playerFilter);

if ($check_player) {
    if ($check_player['team1_id'] == $teamId) {
        foreach ($check_player['team_1'] as &$player) {
            if ($player['_id'] == $playerId) {
                $player_info = $player;
                $player['player_role'] = $playerRole;
            } else {
                $response = [
                    'status_code' => '404',
                    'message' => 'player are not present'
                ];
            }
        }
        $document = [
            '$push' => [
                'team_1' => $check_player['team_1']
            ]
        ];
    } else {
        $response = [
            'status_code' => '400',
            'message' => 'team are not present'
        ];
    }



    $updateRole = $matchCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($matchId)],
        $document
    );

    if ($updateRole->getModifiedCount() > 0) {
        $response = [
            'status_code' => '200',
            'message' => $player_info
        ];
    } else {
        $response = [
            'status_code' => '400',
            'message' => 'Player role update failed'
        ];
    }
} else {
    $response = [
        'status_code' => '400',
        'message' => 'record not found'
    ];
}

echo json_encode($response);
