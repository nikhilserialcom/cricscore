<?php
session_start();
require 'partials/mongodbconnect.php';

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
            'userName' => $findName['userName'],
            'batting' => [
                'runs' => 0,
                'ball' => 0,
                'four' => 0,
                'six' => 0,
                'strikeRate' => 0,
                'batStatus' => "not out"
            ],
            'bowling' => [
                'runs' => 0,
                'over' => 0,
                'wicket' => 0,
                'four' => 0,
                'six' => 0,
                'economy' => 0,
                'maidenOver' => 0,
                'wideBall' => 0,
                'noBall' => 0,
            ],
            'fielder' => [
                'misRun' => 0,
                'saveRun' => 0,
                'dropCatch' => 0,
                'catch' => 0,
                'stumped' => 0
            ]
        ];

        $finalTeamA[] = $addPlayer;
    }

    foreach ($teamB_player['players'] as $teamB) {
        $filterPlayer = ['_id' => new ObjectId($teamB)];
        $findName = $userCollection->findOne($filterPlayer);
        $addPlayer = [
            'player_id' => $teamB,
            'userName' => $findName['userName'],
            'batting' => [
                'runs' => 0,
                'ball' => 0,
                'four' => 0,
                'six' => 0,
                'strikeRate' => 0,
                'batStatus' => "not out"
            ],
            'bowling' => [
                'runs' => 0,
                'over' => 0,
                'wicket' => 0,
                'economy' => 0,
                'maidenOver' => 0,
                'wideBall' => 0,
                'noBall' => 0,
                'four' => 0,
                'six' => 0,
                'extra' => [
                    'W' => 0,
                    'NB' => 0,
                ]
            ],
            'fielder' => [
                'misRun' => 0,
                'saveRun' => 0,
                'dropCatch' => 0,
                'catch' => 0,
                'stumped' => 0,
                'assitedRunOut' => 0,
                'RunOut' => 0
            ]
        ];

        $finalTeamB[] = $addPlayer;
    }

    if(!empty($officials)){
        $final_data = $officials;
    }
    else{
        $final_data = [
            'scorer' => $_SESSION['userId']
        ];
    }

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
            'players' => $finalTeamB,
            'roles' => $teamB_player['roles']
        ],
        'officials' => $final_data,
    ];

    $createMatch = $matchCollection->insertOne($document);

    if ($createMatch) {
        $response = [
            'status_code' => "200",
            'matchId' => $createMatch->getInsertedId(),
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
