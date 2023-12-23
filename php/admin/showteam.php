<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

if(!isset($_SESSION['userId']))
{
    $response = [
        'status_code' => 400,
        'email' => 'your session is expire'
    ];
}
else{
    $teamData = $teamCollection->find([]);
    
    $team_arr = iterator_to_array($teamData);
    
    if(!empty($team_arr))
    {
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
}


echo json_encode($response);
?>