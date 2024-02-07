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

session_start();

if(!isset($_SESSION['userId'])){
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
}
else{
    $data = json_decode(file_get_contents('php://input'),true);
    
    $teamId = isset($_GET['teamId']) ? $_GET['teamId'] : '';
    
    // $response = array(
    //     'status_code' => 200, 
    //     'teamId' => $teamId
    // );
    
    $playerFilter = ['teamId' => $teamId ];
    $check_player = $playerCollection->find($playerFilter);
    
    $playerData = iterator_to_array($check_player);
    
    if(!empty($playerData))
    {
        $response = array(
            'status_code' => 200,
            'player_arr' => $playerData
        );
    }
    else
    {
        $response = array(
            'status_code' => 404,
            'message' => 'database empty',
        );
    }
}



echo json_encode($response);
?>