<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['matchId'];
$teamId = $data['teamId'];
$wicket_keeper_id = $data['wicketKeeperId'];

// $response = array(
//     'status_code' => "200",
//     'match_id' => $matchId,
//     'team_id' => $teamId,
//     'wicket_keeper_id' => $wicket_keeper_id,
// );

$filterMatch = ['_id' => new MongoDB\BSON\ObjectId($matchId)];
$checkMatch = $matchCollection->findOne($filterMatch);

if($checkMatch)
{
    if($checkMatch['team1_id'] == $teamId)
    {
        foreach($checkMatch['team_1'] as &$filder)
        {
            if($filder['_id'] == $wicket_keeper_id)
            {
                $filder['player_role'] = "wicket Keeper";
            }
        }

        $document = [
            '$set' => [
                'team_1' => $checkMatch['team_1'],
            ]
        ];
    
        $updateRole = $matchCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($matchId)],
            $document);
    
        if($updateRole->getModifiedCount() <= 0)
        {
            $response = array(
                'status_code' => '200',
                'message' => 'Player role update failed'
            );
        }
        else
        {
            $response = array(
                'status_code' => '200',
                'message' => 'change wicket Keeper successfully'
            );
        }
    }
    elseif($checkMatch['team2_id'] == $teamId)
    {
        foreach($checkMatch['team_2'] as &$filder)
        {
            if($filder['_id'] == $wicket_keeper_id)
            { 
                $filder['player_role'] = "wicket Keeper";
            }
        }
        $document = [
            '$set' => [
                'team_2' => $checkMatch['team_2'],
            ]
        ];
    
        $updateRole = $matchCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($matchId)],
            $document);
    
        if($updateRole->getModifiedCount() <= 0)
        {
            $response = array(
                'status_code' => '200',
                'message' => 'Player role update failed'
            );
        }
        else
        {
            $response = array(
                'status_code' => '200',
                'message' => 'change wicket Keeper successfully'
            );
        }
    }
}
else
{
    $response = array(
        'status_code' => '404',
        'message' => 'match database empty'
    );
}
 
echo json_encode($response);
?>