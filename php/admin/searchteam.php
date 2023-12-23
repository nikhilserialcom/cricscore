<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'email' => 'your session is expire'
    ];
} else {
    $teamName = $data['team_name'];

    // $response = array(
    //     'status_code' => '200',
    //     'teamName' => $teamName
    // );

    $teamFilter = ['teamName' => ['$regex' => '.*' . $teamName . '.*', '$options' => 'i']];
    $check_team = $teamCollection->find($teamFilter);

    $arr_of_obj = [];

    foreach ($check_team as $document) {
        $team_data = [
            'id' => $document['_id'],
            'team' => $document['teamName']
        ];

        $arr_of_obj[] = $team_data;
    }

    if (!empty($arr_of_obj)) {
        $response = array(
            'state_code' => '200',
            'arr' => $arr_of_obj
        );
    } else {
        $response = array(
            'state_code' => '404',
            'message' => 'No result found'
        );
    }
}

echo json_encode($response);
?>
