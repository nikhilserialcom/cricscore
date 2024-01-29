<?php

require '../partials/mongodbconnect.php';
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");
header("ngrok-skip-browser-warning: 1");

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