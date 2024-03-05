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

function team_name($teamId)
{
    global $con;
    $collection = $con->selectCollection('crick_heros', 'teams');

    $team_name = $collection->findOne(['_id' => new ObjectId($teamId)]);

    if ($team_name) {
        $name = [
            '_id' => $team_name['_id'],
            'teamName' => $team_name['teamName'],
            'teamProfile' => $team_name['teamProfile']
        ];
    } else {
        $name = "";
    }
    return $name;
}

function player_info($playerId)
{
    global $con;
    $collection = $con->selectCollection('crick_heros', 'Users');

    $player_data = $collection->findOne(['_id' => new ObjectId($playerId)]);

    if ($player_data) {
        $fina_data = [
            '_id' => $player_data['_id'],
            'userName' => $player_data['userName'],
            'userProfile' => isset($player_data['userProfile']) ? $player_data['userProfile'] : "",
            'playerRole' => isset($player_data['playerRole']) ?  $player_data['playerRole'] : '',
            'battingStyle' => isset($player_data['battingStyle']) ? $player_data['battingStyle'] : '',
            'bowlingStyle' => isset($player_data['bowlingStyle']) ? $player_data['bowlingStyle'] : ''
        ];
    } else {
        $fina_data = '';
    }

    return $fina_data;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {

    $matchId = isset($data['matchId']) ?  $data['matchId'] : '';

    if (empty($matchId)) {
        $response = array(
            'status_code' => 422,
        );
    } elseif (!preg_match('/^[0-9a-fA-F]{24}$/', $matchId)) {
        $response = [
            'status_code' => 500,
            'message' => 'Invalid matchId format'
        ];
    } else {
        $matchFilter = ['_id' => new ObjectId($matchId)];
        $checkmatch = $matchCollection->findOne($matchFilter);

        if ($checkmatch) {
            if ($checkmatch['userId'] == $_SESSION['userId']) {

                $final_teamA_players = $final_teamB_players = [];
                $teamA_name = team_name($checkmatch['teamA']);
                $teamB_name = team_name($checkmatch['teamB']);
                $striker = player_info($checkmatch['striker']);
                $nonStriker = player_info(($checkmatch['nonStriker']));
                $bowler = player_info($checkmatch['bowler']);
            
                $wicketKeeper = [
                    'teamAKeeper' => player_info($checkmatch['teamAPlayers']['roles']['wk']),
                    'teamBKeeper' => player_info($checkmatch['teamBPlayers']['roles']['wk'])
                ];
                $inning = [
                    'inningNo' =>  $checkmatch['inning'],
                    'batingTeam' => $checkmatch['currentBatting'],
                ];

                $lastOvers = [
                    [
                        'overNumber' => 1,
                        'balls' => [
                            ['ballNo' => 1, 'runs' => 0],
                            ['ballNo' => 2, 'runs' => 2],
                        ]
                    ]
                ];

                foreach ($checkmatch['teamAPlayers']['players'] as $player) {
                    $final_teamA_players[] = player_info($player['player_id']);
                    if ($checkmatch['striker'] == $player['player_id']) {
                        $striker['batting'] = $player['batting'];
                    } elseif ($checkmatch['nonStriker'] == $player['player_id']) {
                        $nonStriker['batting'] = $player['batting'];
                    } elseif ($checkmatch['bowler'] == $player['player_id']) {
                        $bowler['bowling'] = $player['bowling'];
                    }
                }

                foreach ($checkmatch['teamBPlayers']['players'] as $player) {
                    $final_teamB_players[] = player_info($player['player_id']);
                    if ($checkmatch['striker'] == $player['player_id']) {
                        $striker['batting'] = $player['batting'];
                    } elseif ($checkmatch['nonStriker'] == $player['player_id']) {
                        $nonStriker['batting'] = $player['batting'];
                    } elseif ($checkmatch['bowler'] == $player['player_id']) {
                        $bowler['bowling'] = $player['bowling'];
                    }
                }
                if($checkmatch['inning'] == 1){
                    if($checkmatch['toss']['batting'] == 'teamA') {
                        $batting_team = $teamA_name;
                        $bowler_team = $teamB_name;
                        $batting_players =  $final_teamA_players;
                        $bowler_players = $final_teamB_players;
                        $wicketKeeper = player_info($checkmatch['teamBPlayers']['roles']['wk']);
                    }
                    else{
                        $batting_team = $teamB_name;
                        $bowler_team = $teamA_name;
                        $batting_players =  $final_teamB_players;
                        $bowler_players = $final_teamA_players;
                        $wicketKeeper = player_info($checkmatch['teamAPlayers']['roles']['wk']);
                    }
                    
                    $score = [
                        'totalScore' => isset($checkmatch['firstinning']) ?  $checkmatch['firstinning']['totalScore'] : 0,
                        'wicket' => isset($checkmatch['firstinning']) ?  $checkmatch['firstinning']['wicket'] : 0,
                        'currentOver' => isset($checkmatch['firstinning']) ?  $checkmatch['firstinning']['currentOver'] : 0.0,
                        'extra' => [
                            'by' => 1,
                            'LB' => 1,
                            'NB' => 1,
                            'W' => 4
                        ],
                    ];
                }
                else{
                    if($checkmatch['toss']['batting'] == 'teamA')
                    {
                        $batting_team = $teamB_name;
                        $bowler_team = $teamA_name;
                        $batting_players =  $final_teamB_players;
                        $bowler_players = $final_teamA_players;
                        $wicketKeeper = player_info($checkmatch['teamBPlayers']['roles']['wk']);
                    }
                    else{
                        $batting_team = $teamA_name;
                        $bowler_team = $teamB_name;
                        $batting_players =  $final_teamA_players;
                        $bowler_players = $final_teamB_players;
                        $wicketKeeper = player_info($checkmatch['teamAPlayers']['roles']['wk']);
                    }
                    
                    $score = [
                        'totalScore' => isset($checkmatch['secondinning']) ? $checkmatch['secondinning']['total_score'] : 0,
                        'wicket' => isset($checkmatch['secondinning']) ? $checkmatch['secondinning']['wicket'] : 0,
                        'currentOver' => isset($checkmatch['secondinning']) ? $checkmatch['secondinning']['currentOver'] : 0,
                        'extra' => [
                            'by' => 1,
                            'LB' => 1,
                            'NB' => 1,
                            'W' => 4
                        ],
                    ];
                }

                $match_data = [
                    'inning' => $inning,
                    'battingTeam' => $batting_team,
                    'bowlingTeam' => $bowler_team,
                    'battingTeamPlayers' => $batting_players,
                    'bowlingTeamPlayers' => $bowler_players,
                    'striker' => $striker,
                    'nonStriker' => $nonStriker,
                    'bowler' => $bowler,
                    'wicketKeeper' => $wicketKeeper,
                    'noOfOvers' => $checkmatch['noOfOvers'],
                    'currentOver' => 0,
                    'score' => $score,
                    'lastOver' => $lastOvers
                ];
                $response = [
                    'status_code' => 200,
                    'match' => $match_data
                ];
            } else {
                $response = array(
                    'status_code' => 401,
                );
            }
        } else {
            $response = [
                'status_code' => 404,
                'message' => 'database empty'
            ];
        }
    }
}


echo json_encode($response);
