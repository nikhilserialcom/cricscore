<?php
require '../partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173',
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
        'status_code' => 404,
        'message' => 'your session is expire'
    ];
} else {
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
    $teamA_id = isset($_POST['teamA']) ? $_POST['teamA'] : '';
    $teamB_id = isset($_POST['teamB']) ? $_POST['teamB'] : '';
    $matchType = isset($_POST['matchType']) ? $_POST['matchType'] : '';
    $totalOver = isset($_POST['totalOver']) ? $_POST['totalOver'] : '';
    $over_per_bowler = isset($_POST['overPerBowler']) ? $_POST['overPerBowler'] : '';
    $cityName = isset($_POST['cityName']) ? $_POST['cityName'] : '';
    $groundName = isset($_POST['groundName']) ? $_POST['groundName'] : '';
    $matchDate = isset($_POST['matchDate']) ? $_POST['matchDate'] : '';
    $ballType = isset($_POST['ballType']) ? $_POST['ballType'] : '';
    $patchType = isset($_POST['patchType']) ? $_POST['patchType'] : '';
    $teamA_player = isset($_POST['teamAPlayer']) ? $_POST['teamAPlayer'] : '';
    $teamB_player = isset($_POST['teamBPlayer']) ? $_POST['teamBPlayer'] : '';
    $umpires = isset($_POST['umpires']) ? $_POST['umpires'] : '';
    $scorer = isset($_POST['scorer']) ? $_POST['scorer'] : '';
    $commentator = isset($_POST['commentator']) ? $_POST['commentator'] : '';

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
            "player_role" => ""
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
            "player_role" => ""
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
        'patch_type' => $patchType,
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