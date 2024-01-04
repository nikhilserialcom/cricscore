<?php
session_start();

require 'partials/mongodbconnect.php';

use MongoDB\BSON\ObjectId;

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 404,
        'message' => 'your session is expire'
    ];
} else {
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
    $teamA_id = isset($data['teamA']) ? $data['teamA'] : '';
    $teamB_id = isset($data['teamB']) ? $data['teamB'] : '';
    $matchType = isset($data['matchType']) ? $data['matchType'] : '';
    $totalOver = isset($data['totalOver']) ? $data['totalOver'] : '';
    $over_per_bowler = isset($data['over_per_bowler']) ? $data['over_per_bowler'] : '';
    $cityName = isset($data['cityName']) ? $data['cityName'] : '';
    $groundName = isset($data['groundName']) ? $data['groundName'] : '';
    $matchDate = isset($data['match_date']) ? $data['match_date'] : '';
    $ballType = isset($data['ballType']) ? $data['ballType'] : '';
    $patchType = isset($data['patchType']) ? $data['patchType'] : '';
    $teamA_player = isset($data['teamAPlayer']) ? $data['teamAPlayer'] : '';
    $teamB_player = isset($data['teamBPlayer']) ? $data['teamBPlayer'] : '';
    $umpires = isset($data['umpires']) ? $data['umpires'] : '';
    $scorer = isset($data['scorer']) ? $data['scorer'] : '';
    $commentator = isset($data['commentator']) ? $data['commentator'] : '';

    $finalTeamA = $finalTeamB =  [];
    foreach ($teamA_player as $teamA) {
        $filterPlayer = ['_id' => new ObjectId($teamA)];
        $findName = $playerCollection->findOne($filterPlayer);
        $addPlayer = [
            'player_id' => $teamA,
            'playerName' => $findName['playerName'],
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

        $finalTeamA[] = $addPlayer;
    }

    foreach ($teamB_player as $teamB) {
        $filterPlayer = ['_id' => new ObjectId($teamB)];
        $findName = $playerCollection->findOne($filterPlayer);
        $addPlayer = [
            'player_id' => $teamB,
            'playerName' => $findName['playerName'],
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

        $finalTeamB[] = $addPlayer;
    }

    $document = [
        'userId' => $userId,
        'teamA_id' => $teamA_id,
        'teamB_id' => $teamB_id,
        'match_tpye' => $matchType,
        'total_over' => $totalOver,
        'over_per_bowler' => $over_per_bowler,
        'city_name' => $cityName,
        'gruound_name' => $groundName,
        'match_date' => $matchDate,
        'ball_type' => $ballType,
        '$patch_type' => $patchType,
        'teamA' =>  $finalTeamA,
        'teamB' =>  $finalTeamB,
        'umpires' => $umpires,
        'scorer' => $scorer,
        'commentator' => $commentator
    ];

    $createMatch = $matchCollection->insertOne($document);

    if ($createMatch) {
        $response = [
            'status_code' => "200",
            'message' => "match create successfully !"
        ];
    } else {
        $response = [
            'status_code' => "500",
            'message' => 'connection error'
        ];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);