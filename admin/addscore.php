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

function player_data($data)
{
    global $con;
    $collection = $con->selectCollection('crick_heros', 'Users');
    $user_data = $collection->findOne(['_id' => new ObjectId($data['player_id'])]);
    $final_data = [
        '_id' => $user_data['_id'],
        'userName' => $data['userName'],
        'userProfile' => isset($user_data['userProfile']) ? $user_data['userProfile'] : '',
    ];
    if ($data['playerStatus'] == "bowl") {
        $final_data['bowling'] = $data['bowling'];
    } else {
        $final_data['batting'] = $data['batting'];
    }
    return $final_data;
}

function calculateStrikeRate($runs ,$ball){
    if($ball == 0){
        $striker_rate = 0;
    }
    else{
        $striker_rate = ($runs/$ball) * 100;
    }

    return $striker_rate;
}

function calculateEconomyRate($runs, $ball) {
    if ($ball == 0) {
        return 0; 
    }
    
    $parts = explode('.',$ball);
    $final_run = $runs * 6;
    $over = $parts[0];
    $over_ball = isset($parts[1]) ? $parts[1] : 0;
    $final_ball = $over * 6 + $over_ball; 

    $economyRate = $final_run / $final_ball;
    return $economyRate;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $matchId = isset($data['matchId']) ? $data['matchId'] : '';
    $batsmanId = isset($data['striker']) ? $data['striker'] : '';
    $bowlerId = isset($data['bowler']) ? $data['bowler'] : '';
    $nonStriker = isset($data['nonStriker']) ? $data['nonStriker'] : '';
    $runs = isset($data['runs']) ? $data['runs'] : '';
    $isBoundary = isset($data['isBoundary']) ? $data['isBoundary'] : '';
    $ball_status = isset($data['ballNo']) ? $data['ballNo'] : '';
    $total_run = isset($data['totalRuns']) ? $data['totalRuns'] : '';
    $extra_run = isset($data['extras']) ? $data['extras'] : '';
    $countBall = isset($data['countBall']) ? $data['countBall'] : '';
    $deliveryType = isset($data['deliveryType']) ? $data['deliveryType'] : '';

    // $response = array(
    //     'status_code' => '200',
    //     'data' => $data
    // );
    if (!preg_match('/^[0-9a-fA-F]{24}$/', $matchId)) {
        $response = [
            'status_code' => 500,
            'message' => 'Invalid matchId format'
        ];
    } else {
        $matchId = new ObjectId($matchId);
        $filter = ['_id' => $matchId];
        $event = "startInning";
        $over_data = [];
        $check_find = $matchCollection->findOne($filter);
        if ($check_find) {
            if ($check_find['officials']['scorer'] == $_SESSION['userId']) {

                foreach ($check_find['teamAPlayers']['players'] as $key => $players) {
                    if ($players['player_id'] == $batsmanId) {
                        $check_find['teamAPlayers']['players'][$key]['batting']['runs'] += $runs;
                        if ($countBall == "true") {
                            $check_find['teamAPlayers']['players'][$key]['batting']['ball']++;
                        }

                        if ($isBoundary == "true" && $runs == "4") {
                            $check_find['teamAPlayers']['players'][$key]['batting']['four']++;
                        } elseif ($isBoundary == "true" && $runs == "6") {
                            $check_find['teamAPlayers']['players'][$key]['batting']['six']++;
                        }

                        $striker_rate = calculateStrikeRate($check_find['teamAPlayers']['players'][$key]['batting']['runs'],$check_find['teamAPlayers']['players'][$key]['batting']['ball']);
                        $check_find['teamAPlayers']['players'][$key]['batting']['strikeRate'] = $striker_rate;

                        $players['playerStatus'] = 'bat';
                        $striker = $players;
                    } elseif ($players['player_id'] == $nonStriker) {
                        $players['playerStatus'] = 'bat';
                        $non_striker = $players;
                    } elseif ($players['player_id'] == $bowlerId) {
                        $check_find['teamAPlayers']['players'][$key]['bowling']['runs'] += $runs;
                        if ($check_find['teamAPlayers']['players'][$key]['bowling']['over'] * 10 % 10 < 5) {
                            $check_find['teamAPlayers']['players'][$key]['bowling']['over'] = round($check_find['teamAPlayers']['players'][$key]['bowling']['over'] + 0.1, 1);
                        } else {
                            $check_find['teamAlayers']['players'][$key]['bowling']['over'] = round($check_find['teamAPlayers']['players'][$key]['bowling']['over'] + 0.5, 1);
                        }
                        $players['playerStatus'] = 'bowl';
                        $bowler = $players;
                    }
                }

                foreach ($check_find['teamBPlayers']['players'] as $key => $players) {
                    if ($players['player_id'] == $batsmanId) {
                        $check_find['teamBPlayers']['players'][$key]['batting']['runs'] += $runs;
                        $check_find['teamBPlayers']['players'][$key]['batting']['ball']++;
                        $striker = $players;
                    } elseif ($players['player_id'] == $nonStriker) {
                        $non_striker = $players;
                    } elseif ($players['player_id'] == $bowlerId) {
                        if ($deliveryType == 'wideBall') {
                            $check_find['teamBPlayers']['players'][$key]['bowling']['runs'] += intval($total_run);
                            $check_find['teamBPlayers']['players'][$key]['bowling']['wideBall']++;
                        } elseif ($deliveryType == 'noBall') {
                            $check_find['teamBPlayers']['players'][$key]['bowling']['runs'] += intval($total_run);
                            $check_find['teamBPlayers']['players'][$key]['bowling']['noBall']++;
                        } elseif ($isBoundary == "true" && $runs == "4") {
                            $check_find['teamBPlayers']['players'][$key]['bowling']['four']++;
                        } elseif ($isBoundary == "true" && $runs == "6") {
                            $check_find['teamBPlayers']['players'][$key]['bowling']['six']++;
                        } else {
                            $check_find['teamBPlayers']['players'][$key]['bowling']['runs'] += $runs;
                        }

                        if ($countBall == 'true') {
                            if ($check_find['teamBPlayers']['players'][$key]['bowling']['over'] * 10 % 10 < 5) {
                                $check_find['teamBPlayers']['players'][$key]['bowling']['over'] = round($check_find['teamBPlayers']['players'][$key]['bowling']['over'] + 0.1, 1);
                            } else {
                                $check_find['teamBPlayers']['players'][$key]['bowling']['over'] = round($check_find['teamBPlayers']['players'][$key]['bowling']['over'] + 0.5, 1);
                            }
                        }

                        $economy_rate = calculateEconomyRate( $check_find['teamBPlayers']['players'][$key]['bowling']['runs'],$check_find['teamBPlayers']['players'][$key]['bowling']['over']); 

                        $players['playerStatus'] = 'bowl';
                        $bowler = $players;
                    }
                }

                if ($runs % 2 != 0) {
                    $check_find['striker'] = $nonStriker;
                    $check_find['nonStriker'] = $batsmanId;
                    $final_stirker = player_data($non_striker);
                    $final_non_striker = player_data($striker);
                } else {
                    $check_find['striker'] = $batsmanId;
                    $check_find['nonStriker'] = $nonStriker;
                    $final_stirker = player_data($striker);
                    $final_non_striker = player_data($non_striker);
                }

                if ($check_find['inning'] == "1") {
                        $check_find['firstinning']['totalScore'] += intval($total_run);
                        if ($countBall == "true") {
                            $over =  round($check_find['firstinning']['currentOver'] + 0.1,1);
                        } 
                        else{
                           $over = $check_find['firstinning']['currentOver'];
                        }

                        $balls = [
                            'ballNo' => $over,
                            'runs' => $total_run,
                            'deliveryType' => $deliveryType
                        ];
                        foreach($check_find['firstinning']['over'] as $over){
                            if($over['overNumber'] == intval($check_find['firstinning']['currentOver'])){
                                $over['balls'][] = $balls;
                                $over_data = $over['balls'];
                            }
                        }

                        if ($countBall == 'true') {
                            if ($check_find['firstinning']['currentOver'] * 10 % 10 < 5) {
                                $check_find['firstinning']['currentOver'] = round($check_find['firstinning']['currentOver'] + 0.1, 1);
                            } else {
                                $check_find['firstinning']['currentOver'] = round($check_find['firstinning']['currentOver'] + 0.5, 1);
                                $event = "overComplete";
                                $over_data = [];
                                if ($runs % 2 == 0) {
                                    $check_find['striker'] = $nonStriker;
                                    $check_find['nonStriker'] = $batsmanId;
                                    $final_stirker = player_data($non_striker);
                                    $final_non_striker = player_data($striker);
                                } else {
                                    $check_find['striker'] = $batsmanId;
                                    $check_find['nonStriker'] = $nonStriker;
                                    $final_stirker = player_data($striker);
                                    $final_non_striker = player_data($non_striker);
                                }
                            }
                        }
    
                        if ($deliveryType == "wideBall") {
                            $check_find['firstinning']['extra']['W']++;
                        } elseif ($deliveryType == "noBall") {
                            $check_find['firstinning']['extra']['NB']++;
                        } elseif ($deliveryType == "bye") {
                            $check_find['firstinning']['extra']['by']++;
                        } elseif ($deliveryType == "lagBye") {
                            $check_find['firstinning']['extra']['LB']++;
                        }
                        $inning = [
                            'totalScore' => $check_find['firstinning']['totalScore'],
                            'wicket' => $check_find['firstinning']['wicket'],
                            'currentOver' => $check_find['firstinning']['currentOver'],
                        ];
                   
                } else {
                    $check_find['secondinning']['totalScore'] += intval($total_run);
                    if ($countBall == "true") {
                        $over =  round($check_find['secondinning']['currentOver'] + 0.1,1);
                    } 
                    else{
                       $over = $check_find['secondinning']['currentOver'];
                    }
                    $balls = [
                        'ballNo' => $over,
                        'runs' => $total_run,
                        'deliveryType' => $deliveryType
                    ];
                    foreach($check_find['secondinning']['over'] as $over){
                        if($over['overNumber'] == intval($check_find['secondinning']['currentOver'])){
                            $over['balls'][] = $balls;
                            $over_data = $over['balls'];
                        }
                    }

                    if($countBall == "true"){
                        if ($check_find['secondinning']['currentOver'] * 10 % 10 < 5) {
                            $check_find['secondinning']['currentOver'] = round($check_find['secondinning']['currentOver'] + 0.1, 1);
                        } else {
                            $check_find['secondinning']['currentOver'] = round($check_find['secondinning']['currentOver'] + 0.5, 1);
                            $event = "overComplete";
                            $over_data = [];
                            if ($runs % 2 == 0) {
                                $check_find['striker'] = $nonStriker;
                                $check_find['nonStriker'] = $batsmanId;
                                $final_stirker = player_data($non_striker);
                                $final_non_striker = player_data($striker);
                            } else {
                                $check_find['striker'] = $batsmanId;
                                $check_find['nonStriker'] = $nonStriker;
                                $final_stirker = player_data($striker);
                                $final_non_striker = player_data($non_striker);
                            }
                        }
                    }

                    if ($deliveryType == "wideBall") {
                        $check_find['secondinning']['extra']['W']++;
                    } elseif ($deliveryType == "noBall") {
                        $check_find['secondinning']['extra']['NB']++;
                    } elseif ($deliveryType == "bye") {
                        $check_find['secondinning']['extra']['by']++;
                    } elseif ($deliveryType == "lagBye") {
                        $check_find['secondinning']['extra']['LB']++;
                    }
                    $inning = [
                        'totalScore' => $check_find['secondinning']['totalScore'],
                        'wicket' => $check_find['secondinning']['wicket'],
                        'currentOver' => $check_find['secondinning']['currentOver'],
                    ];
                }


                $final_bowler = player_data($bowler);

                $update_score = $matchCollection->replaceOne($filter, $check_find);

                $response = array(
                    'status_code' => 200,
                    'striker' => $final_stirker,
                    'nonStriker' => $final_non_striker,
                    'bowler' => $final_bowler,
                    'event' => $event,
                    'score' => $inning,
                    'over' => $over_data
                );
            } else {
                $response = array(
                    'status_code' => 401,
                    'message' => 'You are not allowed to score in this match.'
                ); 
            }
        } else {
            $response = array(
                'status_code' => 404,
                'message' => "Such a Match does not exist"
            );
        }
    }
}


echo json_encode($response);
