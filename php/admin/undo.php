<?php
require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['matchId'];
$batsmanId = $data['batsmanId'];
$bowlerId = $data['bowlerId'];
$removeRun = $data['removerun'];

// $response = array(
//     'status_code' => '200',
//     'matchId' => $matchId,
//     'batsMan' => $batsmanId,
//     'bowlerId' => $bowlerId,
//     'removeRun' => $removeRun
// );

$filterMatch = ['_id' => new MongoDB\BSON\ObjectId($matchId)];
$checkMatch = $matchCollection->findOne($filterMatch);

if($checkMatch)
{
    $oldover = $checkMatch['team1_over'];
    foreach($checkMatch['team_1'] as $batsman)
    {
        if($batsman['_id'] == $batsmanId)
        {
            if($removeRun == "1")
            {
                $batsman['bat_liveRun'] = $batsman['bat_liveRun'] - $removeRun;
                $batsman['bat_ball']--;
            }
            else
            {
                $batsman['bat_liveRun'] = $batsman['bat_liveRun'] - $removeRun;
                $batsman['bat_ball']--;
            }
        }
    }

    foreach($checkMatch['team_2'] as $bowler)
    {
        if($bowler['_id'] == $bowlerId)
        {
            
            $bowler['ball_liveRun'] = $bowler['ball_liveRun'] - $removeRun;
            if($bowler['ball_over']  * 10 % 10 < 5)
            {
                $bowler['ball_over'] = round($bowler['ball_over'] - 0.1, 1);
                $totalTeam1over = round($oldover - 0.1,1);
            }
            else
            {
                $bowler['ball_over'] =  round($bowler['ball_over'] - 0.5, 1);
                $totalTeam1over = round($oldover - 0.5,1);
                // if($removeRun == "1" || $removeRun == "3")
                // {
                //     $striker = $batsmanId;
                //     $non_striker = $check_player['non_striker'];
                // }
                // else
                // {
                //     $striker = $check_player['non_striker'];
                //     $non_striker = $batsmanId;
                // }
            }
            
        }
    }
    $oldscore = $checkMatch['team1_score'];
    $totalteamScore = $oldscore - $removeRun;
    $document = [
        '$set' => [
            'team1_score' => $totalteamScore,
            'team1_over' => $totalTeam1over,
            'team_1' => $checkMatch['team_1'],
            'team_2' => $checkMatch['team_2']
        ]
    ];

    $updateRole = $matchCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($matchId)],
        $document);

    if($updateRole->getModifiedCount() <= 0)
    {
        $response = array(
            'status_code' => '200',
            'message' => 'update failed'
        );
    }
    else
    {
        $response = array(
            'status_code' => '200',
            'message' => 'match update successfully'
        );
    }

}
else
{
    $response = array(
        'status_code' => "404",  
        'massage' => 'database empty'
    );

}

echo json_encode($response);
?>