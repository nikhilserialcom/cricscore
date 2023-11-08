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

// $response = array(
//     'status_code' => 200,
//     'matchId' => $matchId,
//     'teamId' => $teamId
// );

$matchFilter = ['_id' => new MongoDB\BSON\ObjectId($matchId)];
$check_match = $matchCollection->findOne($matchFilter);

if($check_match)
{
    if($check_match['team1_id'] == $teamId)
    {
        $response = array(
            'status_code' => 200,
            'bowler' => $check_match['team_1']
        );
    }
    elseif($check_match['team2_id'] == $teamId )
    {
        $response = array(
            'status_code' => 200,
            'bowler' => $check_match['team_2']
        );
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