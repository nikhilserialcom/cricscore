<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'), true);

$matchId = isset($data['match_id']) ? new MongoDB\BSON\ObjectId($data['match_id']) : '';
$teamId = isset($data['teamId']) ? $data['teamId'] : '';
$newbatsamanId = isset($data['newbatsmanId']) ? $data['newbatsmanId'] : '';

// $response = array(
//     'match_id' => $matchId,
//     'teamId' => $teamId,
//     'new_batsman_id' => $newbatsamanId,
// );

$matchFilter = ['_id' => $matchId];
$checkMatch = $matchCollection->findOne($matchFilter);

if ($checkMatch) {
    if ($checkMatch['team1_id'] == $teamId) {
        $update = [
            '$set' => [
                'striker' => $newbatsamanId,
            ]
        ];
    } elseif ($checkMatch['team2_id'] == $teamId) {
        $update = [
            '$set' => [
                'striker' => $newbatsamanId,
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
        'status_code' => '400',
        'message' => 'database empty'
    );
}

echo json_encode($response);
