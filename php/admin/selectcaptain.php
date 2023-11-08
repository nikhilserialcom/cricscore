<?php

require '../partials/mongodbconnect.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['matchId'];
$playerId = $data['playerId'];
$playerRole = $data['role'];

$playerFilter = [
    '_id' => new MongoDB\BSON\ObjectId($matchId),
    'team_1._id' => $playerId
];

$check_player = $matchCollection->findOne($playerFilter);

if($check_player)
{
    foreach($check_player['team_1'] as &$player)
    {
        if($player['_id'] == $playerId)
        {
            $player['liveRun'] += $playerRole;
            $document = [
                '$set' => [
                    'team_1' => $check_player['team_1']
                ]
            ];

            $updateRole = $matchCollection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($matchId)],
                $document);

            if($updateRole->getModifiedCount() > 0)
            {
                $response = [
                    'status_code' => '200',
                    'message' => $player
                ];
            } else {
                $response = [
                    'status_code' => '400',
                    'message' => 'Player role update failed'
                ];
            }
            break;
        }
        else
        {
            $response = [
                'status_code' => '404',
                'message' => 'player are not present'
            ];
        }
    }
    
}
else
{
    $response = [
        'status_code' => '400',
        'message' => 'record not found'
    ];
}

echo json_encode($response);
?>