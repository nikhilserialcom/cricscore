<?php

session_start();

require '../partials/mongodbconnect.php';

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($_SESSION['userId']))
{
    $response = [
        'status_code' => 404,
        'message' => 'your session is expire'
    ];
}
else{
    $matchId = isset($data['matchId']) ? new MongoDB\BSON\ObjectId($data['matchId']) : '';
    $toss = isset($data['team_id']) ? $data['team_id'] : '';
    $elected = isset($data['elected']) ? $data['elected'] : '';
    
    $match_fillter = ['_id' => $matchId];
    $matches = $matchCollection->findOne($match_fillter);
    
    if ($matches) {
        $document = [
            '$set' => [
               'toss' => $toss,
               'elected' => $elected
            ]
        ];
    
        $update_match = $matchCollection->updateOne(['_id' => $matchId], $document);
        if ($update_match->getModifiedCount() > 0) {
            $response = [
                'status_code' => '200',
                'message' => $matches
            ];
        } else {
            $response = [
                'status_code' => '400',
                'message' => 'match update failed'
            ];
        }
    } else {
        $response = [
            'status_code' => '404',
            'message' => 'database empty'
        ];
    }
}


echo json_encode($response, JSON_PRETTY_PRINT);
