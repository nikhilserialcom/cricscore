<?php

require 'partials/mongodbconnect.php';
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

$data = json_decode(file_get_contents('php://input'),true);

if(!isset($_SESSION['userId'])) 
{
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
}
else{
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
    $profile = isset($_FILES['teamProfile']) ? $_FILES['teamProfile'] : null;
    $teamName = isset($_POST['teamName']) ? $_POST['teamName'] : '';
    $teamCity = isset($_POST['teamcity']) ? $_POST['teamcity'] : '';
   
    // $response = [
    //     'profile_name' => $profile['tmp_name'],
    //     'team_name' => $teamName,
    //     'teamState' => $teamState,
    //     'team_city' => $teamCity
    // ];

    
    $Filter = ['teamName' => $teamName,'teamCity' => $teamCity];
    $checkTeam = $teamCollection->findOne($Filter);
    if($checkTeam)
    {
        $response = [
            'status_code' => '422',
            'message' => 'team already exist'
        ];
    }
    else
    {
       $document = [
            'userId' => $userId,
            'teamName' => $teamName,   
            'teamCity' => $teamCity
        ];

        if($profile){
            $teamProfileTmpName = $profile['tmp_name'];
            $teamnewpart = explode('.',$profile['name']);
            $extension = end($teamnewpart);
            $teamProfileNewName = rand(111111111,999999999). "." . $extension;
            $profileDir = 'profile/teams_profile/';
            $profilePath = $profileDir.$teamProfileNewName;
    
            $document['teamProfile'] = $profilePath;
            move_uploaded_file($teamProfileTmpName, $profilePath);
        }
    
        $teamInfo = $teamCollection->insertOne($document);
    
        if($teamInfo->getInsertedCount() > 0)
        {
            $insertedTeam = $teamCollection->findOne(['_id' => $teamInfo->getInsertedId()]);
            $response = [
                'status_code' => '200',
                'team_data' => $insertedTeam,
                'message' => 'team added successfully'
            ];
        }
        else 
        {
            $response = [
                'status_code' => '500',
                'message' => 'somthing went worng'
            ];
        } 
    }
}



echo json_encode($response,JSON_PRETTY_PRINT);
?>