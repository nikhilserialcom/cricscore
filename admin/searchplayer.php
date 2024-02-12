<?php
require '../partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173',
];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if (in_array($origin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");
header("ngrok-skip-browser-warning: 1");


$playerName = isset($_GET['search_input']) ? $_GET['search_input'] : '';

// $response = array(
//     'playerName' => $playerName
// );

$playerFilter = [
    '$or' => [
        ['userName' => ['$regex' => '.*' . $playerName . '.*', '$options' => 'i']],
        ['mobileNumber' => ['$regex' => '.*' . $playerName . '.*', '$options' => 'i']]
    ]
];

$options = ['limit' => 20];
$check_player = $userCollection->find($playerFilter,$options);

$arr_of_object = [];

foreach ($check_player as $document) {
    $player_data = [
        '_id' => $document['_id'],
        'player_profile' => isset($document['userProfile']) ? $document['userProfile'] :'',
        'player_name' => $document['userName']
    ];
    $arr_of_object[] = $player_data;
}

usort($arr_of_object,function($a,$b) {
    return strlen($a['player_name']) - strlen($b['player_name']);
});

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



echo json_encode($response);
