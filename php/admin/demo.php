<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

$matchId = isset($data['matchId']) ? $data['matchId'] : '';
$teamId = isset($data['teamId']) ?  $data['teamId'] : '';
$playerId = isset($data['playerId']) ? $data['playerId'] : '';

$finalId = [];

foreach ($playerId as $id) {
    $addplayer = [
        '_id' => $id,
        'playerName' => 'playerName',
        'bat_4' => "0",
        'bat_6' => "0",
        'bat_liveRun' => "0",
        'bat_ball' => "0",
        'bat_strike_rate' => "0",
        'ball_over' => "0",
        'ball_maiden' => "0",
        'ball_wicket' => "0",
        'ball_liveRun' => "0",
        'ball_no_bowl' => "0",
        'ball_wides_bowled' => "0",
        'ball_economy' => "0",
        'run_saved' => "0",
        'run_missed' => "0",
        "player_role" => "0"
    ];
    $finalId[] = $addplayer;
}


$response = array(
    'match_id' => $matchId,
    'teamId' => $teamId,
    'new_batsman_id' => $finalId,
);

echo json_encode($response);
