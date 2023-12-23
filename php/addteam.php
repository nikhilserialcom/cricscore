<?php

require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

$data = json_decode(file_get_contents('php://input'),true);

if(!isset($_SESSION['userId'])) 
{
    $response = [
        'status_code' => 400,
        'email' => 'your session is expire'
    ];
}
else{
    $profile = $_FILES['imageFile'];
    $teamName = $_POST['teamName'];
    $teamState = $_POST['teamstate'];
    $teamCity = $_POST['teamcity'];
    $teamProfileTmpName = $_FILES['imageFile']['tmp_name'];
    $teamnewpart = explode('.',$profile['name']);
    $extension = end($teamnewpart);
    $teamProfileNewName = rand(111111111,999999999). "." . $extension;
    $profileDir = 'profile/';
    $profilePath = $profileDir.$teamProfileNewName;
    // if($profile)
    // {
    //     $response = [
    //         'profile' => $_FILES['imageFile']['name'],
    //         'newname' => $teamProfileNewName,
    //         'teamname' => $teamName,
    //         'state' => $teamState,
    //         'city' => $teamCity
    //     ];
    // }
    
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
            'teamName' => $teamName,
            'teamProfile' => $profilePath,   
            'teamState' => $teamState,
            'teamCity' => $teamCity
        ];
    
        $teamInfo = $teamCollection->insertOne($document);
    
        if($teamInfo->getInsertedCount() > 0)
        {
            move_uploaded_file($teamProfileTmpName, $profilePath);
            $response = [
                'status_code' => '200',
                'message' => 'team added successfully'
            ];
        }
        else 
        {
            $response = [
                'status_code' => '422',
                'message' => 'somthing went worng'
            ];
        } 
    }
}



echo json_encode($response,JSON_PRETTY_PRINT);
?>