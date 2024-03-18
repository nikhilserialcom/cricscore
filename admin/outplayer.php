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
        'bowling' => $data['bowling']
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
    $batsmanId = isset($data['batsman']) ? $data['batsman'] : '';
    $bowlerId = isset($data['bowler']) ? $data['bowler'] : '';
    $filder = isset($data['fielder']) ? $data['fielder'] : '';
    $out_style = isset($data['type']) ?  $data['type'] : '';

    $filter = ['_id' => $matchId];
    $find_match = $matchCollection->findOne($filter);

    $overComplete = $changeNonStriker = $changeStriker = false;

    if ($find_match) {
        if ($find_match['officials']['scorer'] == $_SESSION['userId']) {
            if($out_style == "Caught and Bowled"){
                $fielder = $bowlerId;
            }
            else{
                $fielder = $filder;
            }
            foreach ($find_match['teamAPlayers']['players'] as $key => $player) {
                if ($player['player_id'] == $batsmanId) {
                    $player['batting']['batStatus'] = "out";
                    $player['batting']['outStyle'] = $out_style;
                    $batsman = $player;
                }
            }

            foreach ($find_match['teamBPlayers']['players'] as $key => $player) {
                if ($player['player_id'] == $bowlerId) {
                    $player['bowling']['wicket']++;
                    if ($player['bowling']['over'] * 10 % 10 < 5) {
                        $player['bowling']['over'] = round($player['bowling']['over'] + 0.1, 1);
                    } else {
                        $player['bowling']['over'] = round($player['bowling']['over'] + 0.5, 1);
                    }
                    $bowler = $player;
                } 

                if ($player['player_id'] == $fielder) {
                    if($out_style == "Stumped Out"){
                        $player['filder']['stumped']++; 
                    }
                    else{
                        $player['filder']['catch']++;
                    }
                }
            }

            if ($find_match['striker'] == $batsmanId) {
                $changeStriker = true;
                $find_match['striker'] = '';
            } else {
                $changeNonStriker = true;
                $find_match['nonStriker'] = '';
            }
            if ($find_match['inning'] == 1) {
                $find_match['firstinning']['wicket']++;
                $over =  round($find_match['firstinning']['currentOver'] + 0.1, 1);

                $balls = [
                    'ballNo' => $over,
                    'runs' => "W",
                    'deliveryType' => 'fair'
                ];
                foreach ($find_match['firstinning']['over'] as $over) {
                    if ($over['overNumber'] == intval($find_match['firstinning']['currentOver'])) {
                        $over['balls'][] = $balls;
                        $over_data = $over['balls'];
                    }
                }

                if ($find_match['firstinning']['currentOver'] * 10 % 10 < 5) {
                    $find_match['firstinning']['currentOver'] = round($find_match['firstinning']['currentOver'] + 0.1, 1);
                } else {
                    $find_match['firstinning']['currentOver'] = round($find_match['firstinning']['currentOver'] + 0.5, 1);
                    $overComplete = true;
                }

                $score = [
                    'totalScore' => isset($find_match['firstinning']) ?  $find_match['firstinning']['totalScore'] : 0,
                    'wicket' => isset($find_match['firstinning']) ?  $find_match['firstinning']['wicket'] : 0,
                    'currentOver' => isset($find_match['firstinning']) ?  $find_match['firstinning']['currentOver'] : 0.0,
                ];
            } else {
                $find_match['secondinning']['wicket']++;
            }

            $final_bowler = player_data($bowler);
            $event   = [
                'changeStriker' => $changeStriker,
                'changeNonStriker' => $changeNonStriker,
                'overComplete' =>  $overComplete
            ];

            $update_score = $matchCollection->replaceOne($filter, $find_match);
            $response = array(
                'status_code' => 200,
                'bowler' => $final_bowler,
                'score' => $score,
                'event' => $event,
                'over' => $over_data,
            );
        } else {
            $response = array(
                'status_code ' => 401,
                'message' => "You are not allowed to score in this match."
            );
        }
    } else {
        $response = array(
            'status_code' => 404,
            'message' => "Such a Match does not exist"
        );
    }
}


echo json_encode($response);
