<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['match_id'];
$teamId = $data['teamId'];
$newbatsamanId = $data['newbatsmanId'];

// $response = array(
//     'match_id' => $matchId,
//     'teamId' => $teamId,
//     'new_batsman_id' => $newbatsamanId,
// );

// $addplayer = [
//     '_id' => $newbatsamanId,
//     'playerName' => $checkplayer['playerName'],
//     'bat_4' => "0",
//     'bat_6' => "0",
//     'bat_liveRun' => "0",
//     'bat_ball' => "0",
//     'bat_strike_rate' => "0",
//     'ball_over' => "0",
//     'ball_maiden' => "0",
//     'ball_wicket' => "0",
//     'ball_liveRun' => "0",
//     'ball_no_bowl' => "0",
//     'ball_wides_bowled' => "0",
//     'ball_economy' => "0"
// ];

$matchFilter = ['_id' => new MongoDB\BSON\ObjectId($matchId)];
$checkMatch = $matchCollection->findOne($matchFilter);

if($checkMatch)
{
    if($checkMatch['team1_id'] == $teamId)
    {
        $update = [
            '$set' => [
                'striker' => $newbatsamanId,
            ]
        ];
    
        $updatePlayer = $matchCollection->updateOne($matchFilter,$update);
        if($updatePlayer->getModifiedCount() > 0)
        {
            $response = array(
                'status_code' => '200',
                'match' => 'add player successfully'
            );
        }
        else
        {
            $response = array(
                'status_code' => '422',
                'match' => 'network error'
            );
        }    
    }
    elseif($checkMatch['team2_id'] == $teamId)
    {
        $update = [
            '$set' => [
                'striker' => $newbatsamanId,
            ]
        ];
    
        $updatePlayer = $matchCollection->updateOne($matchFilter,$update);
        if($updatePlayer->getModifiedCount() > 0)
        {
            $response = array(
                'status_code' => '200',
                'match' => 'add player successfully'
            );
        }
        else
        {
            $response = array(
                'status_code' => '422',
                'match' => 'network error'
            );
        }
    }   
}
else
{
    $response = array(
        'status_code' => '400'
    );
}

echo json_encode($response);
?>