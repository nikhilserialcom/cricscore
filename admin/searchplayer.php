<?php
require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

$data = json_decode(file_get_contents('php://input'), true);

if ($_SESSION['userId']) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $playerName = isset($data['playerName']) ? $data['playerName'] : '';

    // $response = array(
    //     'playerName' => $playerName
    // );

    $playerFilter = ['playerName' => ['$regex' => '.*' . $playerName . '.*', '$options' => 'i']];
    $check_player = $playerCollection->find($playerFilter);

    $arr_of_object = [];

    foreach ($check_player as $document) {
        $player_data = [
            'id' => $document['_id'],
            'player' => $document['playerName']
        ];
        $arr_of_object[] = $player_data;
    }

    if (!empty($arr_of_object)) {
        $response = array(
            'status_code' => '200',
            'arr' => $arr_of_object
        );
    } else {
        $response = array(
            'status_code' => '404',
            'message' => 'database empty'
        );
    }
}


echo json_encode($response);
