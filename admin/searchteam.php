<?php

require '../partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.26:5173/',
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



$teamName = isset($_GET['search_input']) ? $_GET['search_input'] : '';
$members  = isset($_GET['addMembers']) ? $_GET['addMembers'] : '';

// $response = array(
//     'status_code' => '200',
//     'teamName' => $teamName
// );

$teamFilter = [
    '$or' => [
        ['teamName' => ['$regex' => '.*' . $teamName . '.*', '$options' => 'i']],
        ['teamCity' => ['$regex' => '.*' . $teamName . '.*', '$options' => 'i']]
     
    ]
];

$options = [
    'limit' => 20,
]; 

$check_team = $teamCollection->find($teamFilter,$options);

$arr_of_obj = [];

foreach ($check_team as $document) {
    $team_data = [
        '_id' => $document['_id'],
        'teamProfile' => !empty($document['teamProfile']) ? $document['teamProfile'] : '',
        'teamName' => $document['teamName'],
        'teamCity' => $document['teamCity']
    ];
    if($members == "true"){
        $team_data['member'] = $document['member'];
    }

    $arr_of_obj[] = $team_data;
}

usort($arr_of_obj,function($a,$b) {
    return strlen($a['teamName']) - strlen($b['teamName']);
});

if (!empty($arr_of_obj)) {
    $response = array(
        'status_code' => '200',
        'arr' => $arr_of_obj
    );
} else {
    $response = array(
        'status_code' => '404',
        'message' => 'No result found'
    );
}

echo json_encode($response);
