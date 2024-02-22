<?php
session_start();
require 'partials/mongodbconnect.php';

use MongoDB\BSON\ObjectId;
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.23:5173',
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

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {

    $data = json_decode(file_get_contents('php://input'), true);

    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
    $teamA_id = isset($data['teamA']) ? $data['teamA'] : '';
    $teamB_id = isset($data['teamB']) ? $data['teamB'] : '';
    $matchType = isset($data['matchType']) ? $data['matchType'] : '';
    $totalOver = isset($data['noOfOvers']) ? $data['noOfOvers'] : '';
    $over_per_bowler = isset($data['noOfOversPerBowler']) ? $data['noOfOversPerBowler'] : '';
    $cityName = isset($data['cityName']) ? $data['cityName'] : '';
    $ground = isset($data['ground']) ? $data['ground'] : '';
    $matchDate = isset($data['dateTime']) ? $data['dateTime'] : '';
    $powerPlay = isset($data['powerplay']) ? $data['powerplay'] : '';
    $ballType = isset($data['ballType']) ? $data['ballType'] : '';
    $patchType = isset($data['pitchType']) ? $data['pitchType'] : ''; 
    $teamA_player = isset($data['teamAPlayers']) ? $data['teamAPlayers'] : '';
    $teamB_player = isset($data['teamBPlayers']) ? $data['teamBPlayers'] : '';
    $officials = isset($data['officials']) ? $data['officials'] : '';

    $teamB_array = $teamB_player['players'];
    $teamA_array = $teamA_player['players'];

    $finalTeamA = $finalTeamB =  [];
    foreach ($teamA_player['players'] as $teamA) {
        $filterPlayer = ['_id' => new ObjectId($teamA)];
        $findName = $userCollection->findOne($filterPlayer);
        $addPlayer = [
            'player_id' => $teamA,
            'playerName' => $findName['userName'],
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
            "player_role" => ""
        ];

        $finalTeamA[] = $addPlayer;
    }

    foreach ($teamB_player['players'] as $teamB) {
        $filterPlayer = ['_id' => new ObjectId($teamB)];
        $findName = $userCollection->findOne($filterPlayer);
        $addPlayer = [
            'player_id' => $teamB,
            'playerName' => $findName['userName'],
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
            "player_role" => ""
        ];

        $finalTeamB[] = $addPlayer;
    }

    // $response = array(
    //     'userId' => $userId,
    //     'teamA' => $teamA_id,
    //     'teamB' => $teamB_id,
    //     'matchTpye' => $matchType,
    //     'noOfOvers' => $totalOver,
    //     'noOfOversPerBowler' => $over_per_bowler,
    //     'cityName' => $cityName,
    //     'powerplay' => $powerPlay,
    //     'gruound' => $ground,
    //     'dateTime' => $matchDate,
    //     'ballType' => $ballType,
    //     'pitchType' => $patchType,
    //     'teamAPlayers' =>  $finalTeamA,
    //     'teamBPlayers' =>  $finalTeamB,
    //     'officials' => $officials,
    // ); 

    $document = [
        'userId' => $userId,
        'teamA' => $teamA_id,
        'teamB' => $teamB_id,
        'matchTpye' => $matchType,
        'noOfOvers' => $totalOver,
        'noOfOversPerBowler' => $over_per_bowler,
        'cityName' => $cityName,
        'powerplay' => $powerPlay,
        'gruound' => $ground,
        'dateTime' => $matchDate,
        'ballType' => $ballType,
        'pitchType' => $patchType,
        'teamAPlayers' => [
            'players' => $finalTeamA,
            'roles' => $teamA_player['roles']
        ],
        'teamBPlayers' => [
            'players' =>$finalTeamB,
            'roles' => $teamB_player['roles']
        ],
        'officials' => $officials,
    ];

    $createMatch = $matchCollection->insertOne($document);

    if ($createMatch) {
        $response = [
            'status_code' => "200",
            'matchId' => $createMatch -> getInsertedId(),
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