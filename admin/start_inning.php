<?php
session_start();

require '../partials/mongodbconnect.php';

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

function get_team_data($team_id, $collection)
{
    $find_team = $collection->findOne(['_id' => new ObjectId($team_id)]);

    $team_data = [
        '_id' => $find_team['_id'],
        'teamName' => $find_team['teamName'],
        'teamCity' => $find_team['teamCity'],
        'teamProfile' => $find_team['teamProfile']
    ];

    return $team_data;
}

function getSelecedPlayer($teamPlayers, $collection)
{
    $selected_players = [];
    foreach ($teamPlayers['players'] as $players) {
        $find_player = $collection->findOne(['_id' => new ObjectId($players['player_id'])]);
        $selected_players[] = [
            '_id' => $find_player['_id'],
            'userName' => $find_player['userName'],
            'userProfile' => isset($find_player['userProfile']) ? $find_player['userProfile'] : '',
            'address' => $find_player['address'],
            'battingStyle' => isset($find_player['battingStyle']) ? $find_player['battingStyle'] : '',
            'bowlingStyle' => isset($find_player['bowlingStyle']) ? $find_player['bowlingStyle'] : '',
            'playerRole' => isset($find_player['playerRole']) ? $find_player['playerRole'] : ''
        ];
    }

    return $selected_players;
}


$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $matchId = isset($data['matchId']) ? $data['matchId'] : '';
    if (!preg_match('/^[0-9a-fA-F]{24}$/', $matchId)) {
        $response = [
            'status_code' => 404,
            'message' => 'Invalid matchId format'
        ];
    } else {
        $matchId = new ObjectId($matchId);
        $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

        $filter = ['_id' => $matchId, 'userId' => $userId];
        $find_match = $matchCollection->findOne($filter);

        if ($find_match) {
            $match_status = isset($find_match['matchStatus']) ? $find_match['matchStatus'] : '';
            if ($match_status == "startInning") {
                $response = array(
                    'status_code' => 202,
                );
            } else {
                $teamA = get_team_data($find_match['teamA'], $teamCollection);
                $teamB =  get_team_data($find_match['teamB'], $teamCollection);
                $teamA_selected_players = getSelecedPlayer($find_match['teamAPlayers'], $userCollection);
                $teamB_selected_players = getSelecedPlayer($find_match['teamBPlayers'], $userCollection);

                $inning_data = [
                    'teamA' => $teamA,
                    'teamB' => $teamB,
                    'teamAPlayer' => $teamA_selected_players,
                    'teamBPlayer' => $teamB_selected_players
                ];
                $response = array(
                    'status_code' => 200,
                    'inningData' => $inning_data
                );
            }
        } else {
            $response = array(
                'status_code' => 500,
                'message' => "match not found"
            );
        }
    }
}
echo json_encode($response, JSON_PRETTY_PRINT);
