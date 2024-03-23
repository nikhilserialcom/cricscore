<?php
session_start();

require '../partials/mongodbconnect.php';

use MongoDB\BSON\ObjectId;

$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.26:5173/',
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

function player_data($data)
{
    global $con;
    $collection = $con->selectCollection('crick_heros', 'Users');
    $user_data = $collection->findOne(['_id' => new ObjectId($data['player_id'])]);
    $final_data = [
        '_id' => $user_data['_id'],
        'userName' => $data['userName'],
        'userProfile' => isset($user_data['userProfile']) ? $user_data['userProfile'] : '',
        'batting' => $data['batting']
    ];

    return $final_data;
}

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $data = json_decode(file_get_contents('php://input'), true);

    $matchId = isset($data['matchId']) ? new ObjectId($data['matchId']) : '';
    $striker = isset($data['striker']) ? $data['striker'] : '';
    $nonStriker = isset($data['nonStriker']) ? $data['nonStriker'] : '';

    $filter = ['_id' => $matchId];
    $find_match = $matchCollection->findOne($filter);
    if ($find_match) {
        if($find_match['officials']['scorer'] == $_SESSION['userId']){
            $updateData = [
                '$set' => [
                    'striker' => $nonStriker,
                    'nonStriker' => $striker
                ]
            ];
            foreach ($find_match['teamAPlayers']['players'] as $players) {
                if ($players['player_id'] == $striker) {
                    $Striker = $players;
                } elseif ($players['player_id'] == $nonStriker) {
                    $non_striker = $players;
                }
            }

            foreach ($find_match['teamBPlayers']['players'] as $players) {
                if ($players['player_id'] == $striker) {
                    $Striker = $players;
                } elseif ($players['player_id'] == $nonStriker) {
                    $non_striker = $players;
                } 

            }
    
            $newStriker = player_data($non_striker);
            $newNonStriker = player_data($Striker);
    
            $changeStriker = $matchCollection->updateOne($filter,$updateData);
            if($changeStriker){
                $response = array(
                    'status_code' => 200,
                    'message' => 'change striker successfully',
                    'striker' => $newStriker,
                    'nonStriker' => $newNonStriker
                );
            }
        }
        else{
            $response = array(
                'status_code ' => 401,
                'message' => "You are not allowed to score in this match."
            );
        }
    } else {
        $response = array(
            'status_code' => 404,
            'message' => 'Such a Match does not exist'
        );
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
