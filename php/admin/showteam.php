<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$teamCollection = $database->teams;
$stateCollection = $database->states_name;
$cityCollection = $database->city_name;

$teamData = $teamCollection->find([]);

$team_arr = iterator_to_array($teamData);

if(!empty($team_arr))
{
    foreach($team_arr as &$team)
    {
        $stateId = $team['teamState'];
        $cityId = $team['teamCity'];
        $stateDocument = $stateCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($stateId)]);
        $cityDocument = $cityCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($cityId)]);
        if($stateDocument && $cityDocument)
        {
            $team['teamState'] = $stateDocument['state_name'];
            $team['teamCity'] = $cityDocument['city_name'];
        }
    }
    $response = array(
        'status_code' => '200',
        'arr' => $team_arr
    );
}
else
{
    $response = array(
        'status_code' => '404',
        'message' => 'database empty'
    );
}

echo json_encode($response);
?>