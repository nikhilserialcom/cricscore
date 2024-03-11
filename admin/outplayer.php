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

if(!isset($_SESSION['userId'])){
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
}
else{

    $data = json_decode(file_get_contents('php://input'), true);
    
    $matchId = isset($data['matchId']) ? new ObjectId($data['matchId']) : '';
    $teamId = $data['teamId'];
    $batsmanId = $data['batsmanId'];
    $bowlerId = $data['bowlerId'];
    $out_style = $data['out_style'];
    
    $response = [];
    
    // $response = array(
    //     'status_code' => '200',
    //     'matchId' => $matchId,
    //     'batsMan' => $batsmanId,
    //     'out_style' => $out_style
    // );
    
    $matchFilter = ['_id' => $matchId];
    $checkMatch = $matchCollection->findOne($matchFilter);
    
    if ($checkMatch) {
        if ($checkMatch['team1_id'] == $teamId) {
            $oldover = $checkMatch['team1_over'];
            $oldteam1wicket = $checkMatch['team1_wicket'];
            foreach ($checkMatch['team_1'] as &$batsman) {
                if ($batsman['_id'] == $batsmanId) {
                    $batsman['bat_wicket'] = $out_style;
                    $batsman['bat_status'] = 'out';
                }
            }
            foreach ($checkMatch['team_2'] as &$bowler) {
                if ($bowler['_id'] == $bowlerId) {
                    $bowler['ball_wicket'] += 1;
                    $team1Wicket = $oldteam1wicket + 1;
                    if ($bowler['ball_over']  * 10 % 10 < 5) {
                        $bowler['ball_over'] = round($bowler['ball_over'] + 0.1, 1);
                        $totalTeam1over = round($oldover + 0.1, 1);
                    } else {
                        $bowler['ball_over'] =  round($bowler['ball_over'] + 0.5, 1);
                        $totalTeam1over = round($oldover + 0.5, 1);
                        $striker = $checkMatch['non_striker'];
                        $non_striker = $batsmanId;
                    }
                }
            }
    
            $document = [
                '$set' => [
                    'team_1' => $checkMatch['team_1'],
                    'team_2' => $checkMatch['team_2'],
                    'team1_over' => $totalTeam1over,
                    'team1_wicket' => $team1Wicket
                ]
            ];
    
            $updateRole = $matchCollection->updateOne(
                ['_id' => $matchId],
                $document
            );
    
            if ($updateRole->getModifiedCount() > 0) {
                $response = array(
                    'status_code' => '200',
                    'message' => 'wicket take by bowler',
                );
            } else {
                $response = array(
                    'status_code' => '404',
                    'message' => 'Player role update failed'
                );
            }
        } elseif ($checkMatch['team2_id'] == $teamId) {
            foreach ($checkMatch['team_2'] as &$batsman) {
                if ($batsman['_id'] == $batsmanId) {
                    $batsman['bat_wicket'] = $out_style;
                }
            }
    
            $document = [
                '$set' => [
                    'team_2' => $checkMatch['team_2'],
                ]
            ];
    
            $updateRole = $matchCollection->updateOne(
                ['_id' => $matchId],
                $document
            );
    
            if ($updateRole->getModifiedCount() > 0) {
                $response = array(
                    'status_code' => '200',
                    'match' => 'wicket take by bowler',
                );
            } else {
                $response = array(
                    'status_code' => '404',
                    'message' => 'Player role update failed'
                );
            }
        } else {
            $response = array(
                'status_code' => '404',
                'match' => 'team is not exist'
            );
        }
    } else {
        $response = array(
            'status_code' => '400',
            'match' => 'database empty'
        );
    }
}


echo json_encode($response);
