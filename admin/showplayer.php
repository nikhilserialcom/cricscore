<?php

require '../partials/mongodbconnect.php';
use MongoDB\BSON\ObjectId as obj; 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['matchId'];
$teamId = $data['teamId'];

// $response = array(
//     'status_code' => 200, 
//     'matchId' => $matchId,
//     'teamId' => $teamId
// );

$matchFilter = ['_id' => new obj($matchId)];
$check_match = $matchCollection->findOne($matchFilter);

if($check_match)
{
    if($check_match['team1_id'] == $teamId)
    {
        $outBatsmen = array();
        foreach($check_match['team_1'] as &$batsman)
        {
            if(($batsman['bat_status'] == "not out") && ($batsman['_id'] != $check_match['non_striker']))
            {
                $outBatsmen[] = $batsman;
            }
        }

        if(!empty($outBatsmen))
        {
            $response = array(
                'status_code' => 200,
                'batsman' => $outBatsmen
            );
        }
    }
    elseif($check_match['team2_id'] == $teamId )
    {
        $outBatsmen = array();
        foreach($check_match['team_2'] as &$batsman)
        {
            if ($batsman['bat_status'] == 'not out') {
                $outBatsmen[] = $batsman;
            }
        }

        if(!empty($outBatsmen))
        {
            $response = array(
                'status_code' => 200,
                'batsman' => $outBatsmen
            );
        }
    }
    else
    {
        $response = array(
            'status_code' => 400,
            'message' => 'network error'
        );
    }
}
else
{
    $response = array(
        'status_code' => 404,
        'message' => 'database empty',
    );
}


echo json_encode($response);
?>