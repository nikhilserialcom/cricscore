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
    $final_data = [
        '_id' => new ObjectId($data['player_id']),
        'userName' => $data['userName'],
        'bowling' => $data['bowling']
    ];
   

    return $final_data;
}

$data = json_decode(file_get_contents('php://input'),true);
if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {

    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
    $matchId = isset($data['matchId']) ? $data['matchId'] : '';
    $bowlerId = isset($data['bowlerId']) ?  $data['bowlerId'] : '';
    
    $matchFilter = ['_id' => new ObjectId($matchId)];
    $check_match = $matchCollection->findOne($matchFilter);
    
    if ($check_match) {

        if($check_match['officials']['scorer'] == $userId){
            
            if($check_match['inning'] == 1){
                foreach ($check_match['firstinning']['over'] as $over) {
                    if ($over['overNumber'] == intval($check_match['firstinning']['currentOver'])) {
                        $over_data = $over['balls'];
                    }
                    else{
                        $over_data = [];
                    }
                }
                if($check_match['firstinning']['bowl_team'] == "teamB"){
                    foreach($check_match['teamBPlayers']['players'] as $player){
                        if($player['player_id'] == $bowlerId){
                            $bowler = $player;
                        }
                    }
                }
                else{
                    foreach($check_match['teamAPlayers']['players'] as $player){
                        if($player['player_id'] == $bowlerId){
                            $bowler = $player;
                        }
                    }
                }
                $final_data = player_data($bowler);
    
                $updateBowler = [
                    '$set' => [
                        'bowler' => $bowlerId
                    ],
                    '$push' => [
                        'firstinning.over' => [
                            'overNumber' => $check_match['firstinning']['currentOver'],
                            'bowler' => array($bowlerId),
                            'balls' => []
                        ]
                    ]
                ];
            }
            else{
                foreach ($check_match['secondinning']['over'] as $over) {
                    if ($over['overNumber'] == intval($check_match['secondinning']['currentOver'])) {
                        $over_data = $over['balls'];
                    }
                    else{
                        $over_data = [];
                    }
                }
                if($check_match['secondininng']['bowl_team'] == "teamB"){
                    foreach($check_match['teamBPlayers']['players'] as $player){
                        if($player['player_id'] == $bowlerId){
                            $bowler = $player;
                        }
                    }
                }
                else{
                    foreach($check_match['teamAPlayers']['players'] as $player){
                        if($player['player_id'] == $bowlerId){
                            $bowler = $player;
                        }
                    }
                }
                $updateBowler = [
                    '$set' => [
                        'bowler' => $bowlerId
                    ],
                    '$push' => [
                        'secondinning.over' => [
                            'overNumber' => $check_match['secondinning']['currentOver'],
                            'bowler' => array($bowlerId),
                            'balls' => []
                        ]
                    ]
                ];
            }
            
            $updatePlayer = $matchCollection->updateOne($matchFilter,$updateBowler);
            if($updatePlayer)
            {
                $response = array(
                    'status_code' => "200",
                    'bowler' => $final_data,
                    'over' => $over_data,
                    'message' => 'bowler change successfully'
                );
            }
        }
        else{
            $response = array(
                'status_code' => 401
            );
        }
    }
    else
    {
        $response = array(
            'status_code' => "400",
            'message' => "database empty" 
        );
    }
}

 
echo json_encode($response, JSON_PRETTY_PRINT);
?>