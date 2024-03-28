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
    ];
    if ($data['playerStatus'] == "bowl") {
        $final_data['bowling'] = $data['bowling'];
    } else {
        $final_data['batting'] = $data['batting'];
    }
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
    $bowlerId = isset($data['bowler']) ? $data['bowler'] : '';


    $filter = ['_id' => $matchId];
    $find_match = $matchCollection->findOne($filter);

    if ($find_match) {
        if ($find_match['officials']['scorer'] == $_SESSION['userId']) {
            if ($find_match['inning'] == 1) {
                foreach ($find_match['firstinning']['over'] as $over) {
                    if ($over['overNumber'] == intval($find_match['firstinning']['currentOver'])) {
                        foreach ($over['balls'] as $ball) {
                            if ($ball['ballNo'] == $find_match['firstinning']['currentOver']) {
                                $lastBall = $ball;
                            }
                        }
                        $balls = iterator_to_array($over['balls']);
                        array_pop($balls);
                        $over['balls'] = $balls;
                    }
                }
            } else {
                foreach ($find_match['secondinning']['over'] as $over) {
                    if ($over['overNumber'] == intval($find_match['secondinning']['currentOver'])) {
                        foreach ($over['balls'] as $ball) {
                            if ($ball['ballNo'] == $find_match['secondinning']['currentOver']) {
                                $lastBall = $ball;
                            }
                        }
                        $balls = iterator_to_array($over['balls']);
                        array_pop($balls);
                        $over['balls'] = $balls;
                    }
                }
            }

            foreach ($find_match['teamAPlayers']['players'] as $key => $players) {
                if ($players['player_id'] == $lastBall['striker']) {
                    $find_match['teamAPlayers']['players'][$key]['batting']['runs'] -= $lastBall['runs'];

                    $find_match['teamAPlayers']['players'][$key]['batting']['ball']--;
                    if (isset($lastBall['boundary']) == true && $lastBall['runs'] == "4") {
                        $find_match['teamAPlayers']['players'][$key]['batting']['four']--;
                    } elseif (isset($lastBall['boundary']) == true && $lastBall['runs'] == "6") {
                        $find_match['teamAPlayers']['players'][$key]['batting']['six']--;
                    }
                    $players['playerStatus'] = 'bat';
                    $Striker = $players;
                } elseif ($players['player_id'] == $lastBall['nonStriker']) {
                    $players['playerStatus'] = 'bat';
                    $non_striker = $players;
                } elseif ($players['player_id'] == $bowlerId) {
                    if ($lastBall['deliveryType'] == "wideBall") {
                        $find_match['teamAPlayers']['players'][$key]['bowling']['runs'] -= $lastBall['totalRuns'];
                        $find_match['teamAPlayers']['players'][$key]['bowling']['wideBall']--;
                    } elseif ($lastBall['deliveryType'] == "noBall") {
                        $find_match['teamAPlayers']['players'][$key]['bowling']['runs'] -= $lastBall['totalRuns'];
                        $find_match['teamAPlayers']['players'][$key]['bowling']['noBall']--;
                    } else {
                        $find_match['teamAPlayers']['players'][$key]['bowling']['runs'] -= $lastBall['runs'];
                    }
                    if (isset($lastBall['boundary']) == true && $lastBall['runs'] == "4") {
                        $find_match['teamAPlayers']['players'][$key]['bowling']['four']--;
                    } elseif (isset($lastBall['boundary']) == true && $lastBall['runs'] == "6") {
                        $find_match['teamAPlayers']['players'][$key]['bowling']['six']--;
                    }
                    if ($lastBall['countBall'] == true) {
                        if ($find_match['teamAPlayers']['players'][$key]['bowling']['over'] * 10 % 10 <= 5) {
                            $find_match['teamAPlayers']['players'][$key]['bowling']['over'] = round($find_match['teamAPlayers']['players'][$key]['bowling']['over'] - 0.1, 1);
                        } else {
                            $find_match['teamAPlayers']['players'][$key]['bowling']['over'] = round($find_match['teamAPlayers']['players'][$key]['bowling']['over'] - 0.5, 1);
                        }
                    }
                    $players['playerStatus'] = 'bowl';
                    $bowler = $players;
                }
            }

            foreach ($find_match['teamBPlayers']['players'] as $key => $players) {
                if ($players['player_id'] == $lastBall['striker']) {
                    if ($lastBall['deliveryType'] == "wideBall") {
                        $find_match['teamBPlayers']['players'][$key]['bowling']['runs'] -= $lastBall['totalRuns'];
                        $find_match['teamBPlayers']['players'][$key]['bowling']['wideBall']--;
                    } elseif ($lastBall['deliveryType'] == "noBall") {
                        $find_match['teamBPlayers']['players'][$key]['bowling']['runs'] -= $lastBall['totalRuns'];
                        $find_match['teamBPlayers']['players'][$key]['bowling']['noBall']--;
                    } else {
                        $find_match['teamBPlayers']['players'][$key]['bowling']['runs'] -= $lastBall['runs'];
                    }

                    $find_match['teamBPlayers']['players'][$key]['batting']['ball']--;
                    if (isset($lastBall['boundary']) == true && $lastBall['runs'] == "4") {
                        $find_match['teamBPlayers']['players'][$key]['batting']['four']--;
                    } elseif (isset($lastBall['boundary']) == true && $lastBall['runs'] == "6") {
                        $find_match['teamBPlayers']['players'][$key]['batting']['six']--;
                    }
                    $players['playerStatus'] = 'bat';
                    $Striker = $players;
                } elseif ($players['player_id'] == $lastBall['nonStriker']) {
                    $players['playerStatus'] = 'bat';
                    $non_striker = $players;
                } elseif ($players['player_id'] == $bowlerId) {
                    $find_match['teamBPlayers']['players'][$key]['bowling']['runs'] -= $lastBall['runs'];

                    if (isset($lastBall['boundary']) == true && $lastBall['runs'] == "4") {
                        $find_match['teamBPlayers']['players'][$key]['bowling']['four']--;
                    } elseif (isset($lastBall['boundary']) == true && $lastBall['runs'] == "6") {
                        $find_match['teamBPlayers']['players'][$key]['bowling']['six']--;
                    }
                    if ($lastBall['countBall'] == true) {
                        if ($find_match['teamBPlayers']['players'][$key]['bowling']['over'] * 10 % 10 <= 5) {
                            $find_match['teamBPlayers']['players'][$key]['bowling']['over'] = round($find_match['teamBPlayers']['players'][$key]['bowling']['over'] - 0.1, 1);
                        } else {
                            $find_match['teamBPlayers']['players'][$key]['bowling']['over'] = round($find_match['teamBPlayers']['players'][$key]['bowling']['over'] - 0.5, 1);
                        }
                    }
                    $players['playerStatus'] = 'bowl';
                    $bowler = $players;
                }
            }

            if ($lastBall['runs'] % 2 != 0 || $lastBall['extra'] % 2 != 0) {
                $find_match['striker'] = $nonStriker;
                $find_match['nonStriker'] = $striker;
                $final_striker = player_data($non_striker);
                $final_non_striker = player_data($Striker);
            } else {
                $find_match['striker'] = $striker;
                $find_match['nonStriker'] = $nonStriker;
                $final_striker = player_data($Striker);
                $final_non_striker = player_data($non_striker);
            }
            if ($find_match['inning'] == 1) {
                $find_match['firstinning']['totalScore'] -= $lastBall['totalRuns'];
                if ($lastBall['deliveryType'] == "wideBall") {
                    $find_match['firstinning']['extra']['W']--;
                } elseif ($lastBall['deliveryType'] == "noBall") {
                    $find_match['firstinning']['extra']['NB']--;
                } elseif ($lastBall['deliveryType'] == "bye") {
                    $find_match['firstinning']['extra']['by']--;
                } elseif ($lastBall['deliveryType'] == "lagBye") {
                    $find_match['firstinning']['extra']['LB']--;
                }
                if($lastBall['countBall'] == true){
                    if ($find_match['firstinning']['currentOver'] * 10 % 10 <= 5) {
                        $find_match['firstinning']['currentOver'] = round($find_match['firstinning']['currentOver'] - 0.1, 1);
                    } else {
                        $find_match['firstinning']['currentOver'] = round($find_match['firstinning']['currentOver'] - 0.5, 1);
                        if ($lastBall['runs'] % 2 == 0 || $lastBall['extra'] % 2 == 0) {
                            $check_find['striker'] = $nonStriker;
                            $check_find['nonStriker'] = $striker;
                            $final_striker = player_data($non_striker);
                            $final_non_striker = player_data($Striker);
                        } else {
                            $check_find['striker'] = $striker;
                            $check_find['nonStriker'] = $nonStriker;
                            $final_striker = player_data($Striker);
                            $final_non_striker = player_data($non_striker);
                        }
                    }
                }
            } else {

                $find_match['secondinning']['totalScore'] -= $lastBall['totalRuns'];
                if ($lastBall['deliveryType'] == "wideBall") {
                    $find_match['secondinning']['extra']['W']--;
                } elseif ($lastBall['deliveryType'] == "noBall") {
                    $find_match['secondinning']['extra']['NB']--;
                } elseif ($lastBall['deliveryType'] == "bye") {
                    $find_match['secondinning']['extra']['by']--;
                } elseif ($lastBall['deliveryType'] == "lagBye") {
                    $find_match['secondinning']['extra']['LB']--;
                }
                if ($lastBall['countBall'] == true) {
                    if ($find_match['secondinning']['currentOver'] * 10 % 10 <= 5) {
                        $find_match['secondinning']['currentOver'] = round($find_match['secondinning']['currentOver'] - 0.1, 1);
                    } else {
                        $find_match['secondinning']['currentOver'] = round($find_match['secondinning']['currentOver'] - 0.5, 1);
                        if ($lastBall['runs'] % 2 == 0 || $lastBall['extra'] % 2 == 0) {
                            $check_find['striker'] = $nonStriker;
                            $check_find['nonStriker'] = $striker;
                            $final_striker = player_data($non_striker);
                            $final_non_striker = player_data($Striker);
                        } else {
                            $check_find['striker'] = $striker;
                            $check_find['nonStriker'] = $nonStriker;
                            $final_striker = player_data($Striker);
                            $final_non_striker = player_data($non_striker);
                        }
                    }
                }
            }

            $update_data = $matchCollection->replaceOne($filter, $find_match);
            $response = array(
                'status_code' => 200,
                'striker' => $final_striker,
                'nonStriker' => $final_non_striker,
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


echo json_encode($response, JSON_PRETTY_PRINT);
