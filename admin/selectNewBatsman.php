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
    $non_striker = isset($data['nonStriker']) ? $data['nonStriker'] : '';

    $matchFilter = ['_id' => $matchId];
    $checkMatch = $matchCollection->findOne($matchFilter);

    if ($checkMatch) {
        if($checkMatch['officials']['scorer'] == $_SESSION['userId']){
            if(!empty($striker)){
                $update = [
                    '$set' => [
                        'striker' => $striker,
                    ]
                ];
            }
            else{
                $update = [
                    '$set' => [
                        'nonStriker' => $non_striker,
                    ]
                ];
            }

            foreach ($checkMatch['teamAPlayers']['players'] as $player) {
                if ($player['player_id'] == $striker) {
                    $data = $player;
                }
                elseif($player['player_id'] == $non_striker){
                    $data = $player;
                }
            }

            foreach ($checkMatch['teamBPlayers']['players'] as $key => $player) {
                if ($player['player_id'] == $striker) {
                    $data = $player;
                } elseif ($player['player_id'] == $non_striker) {
                    $data = $player;
                }
            }

            $final_data = player_data($data);
    
            $updatePlayer = $matchCollection->updateOne($matchFilter, $update);
            if ($updatePlayer) {
                $response = array(
                    'status_code' => '200',
                    'message' => 'batsman seletct successfully',
                    'newBatsman' => $final_data
                );
            } else {
                $response = array(
                    'status_code' => 422,
                    'message' => 'network error'
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


echo json_encode($response);
