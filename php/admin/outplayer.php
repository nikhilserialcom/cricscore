<?php

require '../partials/mongodbconnect.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'), true);

$matchId = $data['matchId'];
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

$matchFilter = ['_id' => new MongoDB\BSON\ObjectId($matchId)];
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
        foreach($checkMatch['team_2'] as &$bowler)
        {
            if($bowler['_id'] == $bowlerId)
            {
                $bowler['ball_wicket'] += 1;
                $team1Wicket = $oldteam1wicket + 1;
                if($bowler['ball_over']  * 10 % 10 < 5)
                {
                    $bowler['ball_over'] = round($bowler['ball_over'] + 0.1, 1);
                    $totalTeam1over = round($oldover + 0.1,1);
                }
                else
                {
                    $bowler['ball_over'] =  round($bowler['ball_over'] + 0.5, 1);
                    $totalTeam1over = round($oldover + 0.5,1);
                    $striker = $check_player['non_striker'];
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
            ['_id' => new MongoDB\BSON\ObjectId($matchId)],
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
            ['_id' => new MongoDB\BSON\ObjectId($matchId)],
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

echo json_encode($response);
