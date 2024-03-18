<?php

session_start();

require '../partials/mongodbconnect.php';

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

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $matchId = isset($data['matchId']) ? new MongoDB\BSON\ObjectId($data['matchId']) : '';
    $toss = isset($data['toss']) ? $data['toss'] : '';
    $striker = isset($data['striker']) ? $data['striker'] : '';
    $non_striker = isset($data['nonStriker']) ? $data['nonStriker'] : '';
    $bowler = isset($data['bowler']) ? $data['bowler'] : '';

    $match_fillter = ['_id' => $matchId];
    $matches = $matchCollection->findOne($match_fillter);

    if ($matches) {
        if (isset($matches['inning'])) {
            $inningStatus = 2;
            $inningType = "secondinning";
            $inning = [
                'bat_team' => $toss['bowling'],
                'bowl_team' => $toss['batting'],
                'totalScore' => 0,
                'wicket' => 0,
                'currentOver' => 0,
                'extra' => [
                    'by' => 0,
                    'LB' => 0,
                    'NB' => 0,
                    'W' => 0
                ],
                'over' => array()
            ];
        } else {
            $inningStatus = 1;
            $inningType = "firstinning";
            $inning = [
                'bat_team' => $toss['batting'],
                'bowl_team' => $toss['bowling'],
                'totalScore' => 0,
                'wicket' => 0,
                'currentOver' => 0,
                'extra' => [
                    'by' => 0,
                    'LB' => 0,
                    'NB' => 0,
                    'W' => 0
                ],
                'over' => array([
                    'overNumber' => 0,
                    'bowler' => array($bowler),
                    'balls' => []
                ]) 
            ];
        }

        $document = [
            '$set' => [
                'toss' => $toss,
                'striker' => $striker,
                'nonStriker' => $non_striker,
                'bowler' => $bowler,
                'inning' => $inningStatus,
                $inningType => $inning,
                'currentBatting' => $toss['batting'],
                'matchStatus' => "startInning"
            ]
        ];

        $update_match = $matchCollection->updateOne(['_id' => $matchId], $document);
        if ($update_match->getModifiedCount() > 0) {
            $response = [
                'status_code' => '200',
                'message' => "start match"
            ];
        }
    } else {
        $response = [
            'status_code' => '404',
            'message' => 'database empty'
        ];
    }
}


echo json_encode($response, JSON_PRETTY_PRINT);
