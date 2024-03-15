<?php
session_start();

require '../partials/mongodbconnect.php';

use MongoDB\BSON\ObjectId;

$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173/',
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

if(!isset($_SESSION['userId'])){
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
}
else{

    $data = json_decode(file_get_contents('php://input'), true);
    
    $matchId = isset($data['matchId']) ? new ObjectId($data['matchId']) : '';
    $batsmanId = isset($data['batsman']) ? $data['batsman'] : '';
    $bowlerId = isset($data['bowler']) ? $data['bowler'] : '';
    $filder = isset($data['filder']) ? $data['filder'] : '';
    $out_style = isset($data['type']) ?  $data['type'] : '';

    $filter = ['_id' => $matchId];
    $find_match = $matchCollection->findOne($filter);

    if($find_match){
        if($find_match['officials']['scorer'] == $_SESSION['userId']){
            foreach($find_match['teamAPlayers']['players'] as $key => $player){
                if($player['player_id'] == $batsmanId){
                    $player['batting']['batStatus'] = "out";
                    $player['batting']['outStyle'] = $out_style;
                    $batsman = $player;
                }
            }

            foreach($find_match['teamBPlayers']['players'] as $key => $player){
                if($player['player_id'] == $bowlerId){
                    $player['bowling']['wicket']++;
                    if ($player['bowling']['over'] * 10 % 10 < 5) {
                        $player['bowling']['over'] = round($player['bowling']['over'] + 0.1, 1);
                    } else {
                        $player['bowling']['over'] = round($player['bowling']['over'] + 0.5, 1);
                    }
                    $bowler = $player['bowling '];
                }
                elseif($player['player_id'] == $filter){
                    $player['filder']['catch']++;
                }
            }

            if($find_match['striker'] == $batsmanId){
                $event = "change striker";
            }
            else{
                $event = "change nonStriker";
            }
            if($find_match['inning'] == 1){
                $find_match['firstinning']['wicket']++;
                if ($find_match['firstinning']['currentOver'] * 10 % 10 < 5) {
                    $find_match['firstinning']['currentOver'] = round($find_match['firstinning']['currentOver'] + 0.1, 1);
                } else {
                    $find_match['firstinning']['currentOver'] = round($find_match['firstinning']['currentOver'] + 0.5, 1);
                    $event = "overComplete";
                }

                $score = [
                    'totalScore' => isset($find_match['firstinning']) ?  $find_match['firstinning']['totalScore'] : 0,
                    'wicket' => isset($find_match['firstinning']) ?  $find_match['firstinning']['wicket'] : 0,
                    'currentOver' => isset($find_match['firstinning']) ?  $find_match['firstinning']['currentOver'] : 0.0,
                ];
            }
            else{
                $find_match['secondinning']['wicket']++;
            }

            $update_score = $matchCollection->replaceOne($filter,$find_match);
            $response = array(
                'status_code' => 200,
                'batsman' => $batsman,
                'bowler' => $bowler,
                'score' => $score,
                'event' => $event
            );
        }
        else{
            $response = array(
                'status_code ' => 401,
                'message' => "You are not allowed to score in this match."
            );
        }
    }
    else{
        $response = array(
            'status_code' => 404,
            'message' => "Such a Match does not exist"
        );
    }
    

}


echo json_encode($response);
