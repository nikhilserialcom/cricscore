<?php

require '../partials/mongodbconnect.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['matchId'];
$batsmanId = $data['batsmanId'];
$bowlerId = $data['bowlerId'];
$scoreInput = $data['score_inuput'];
$ball_status = $data['ball_status'];

$response = []; 

// $response = array(
//     'status_code' => '200',
//     'matchId' => $matchId,
//     'batsMan' => $batsmanId,
//     'bowlerId' => $bowlerId,
//     'score_inuput' => $scoreInput,
//     'status' => $ball_status
// );

$playerFilter = [
    '_id' => new MongoDB\BSON\ObjectId($matchId),
];

$check_player = $matchCollection->findOne($playerFilter);

if($check_player)
{
    // $response = [
    //     'status_code' => '200',
    //     'message' => $check_player,
    // ];
    $batsmanFound = false;
    $oldScore = $check_player['team1_score'];
    $oldteam2Score = $check_player['team2_score'];
    $oldover = $check_player['team1_over'];
    $oldteam2over = $check_player['team2_over'];

    foreach($check_player['team_1'] as &$batsman)
    {
        if($batsman['_id'] == $batsmanId)
        {

            if($scoreInput == "4" && $ball_status == "")
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_4'] ++;
                $batsman['bat_ball']++;
                $striker = $batsmanId;
                $non_striker =$check_player['non_striker'];
            }
            elseif($scoreInput == "6")
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_6'] ++;
                $batsman['bat_ball']++;
                $striker = $batsmanId;
                $non_striker =$check_player['non_striker'];
            }
            elseif($scoreInput == "1" && $ball_status == "")
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_ball'] ++;
                $striker = $check_player['non_striker'];
                $non_striker = $batsmanId;
            }
            elseif($scoreInput == "3" && $ball_status == "")
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_ball'] ++;
                $striker = $check_player['non_striker'];
                $non_striker = $batsmanId;
            }
            elseif($scoreInput == "0")
            {
                $batsman['bat_ball'] ++;
                $striker = $batsmanId;
                $non_striker = $check_player['non_striker'];
            }
            elseif($ball_status == "WD" && $scoreInput)
            {
                if($scoreInput == "1")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                elseif($scoreInput == "2")
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
                elseif($scoreInput == "3")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                else
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
            }
            elseif($ball_status == "NB" && $scoreInput)
            {
                if($scoreInput == "1" && $scoreInput == "3")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                else
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
            }
            elseif($ball_status == "LB" && $scoreInput)
            {
                if($scoreInput == "1" && $scoreInput == "3")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                else
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
            }
            elseif($ball_status == "BYE" && $scoreInput)
            {
                if($scoreInput == "1" && $scoreInput == "3")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                else
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
            } 
            else
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_ball'] ++;
                $striker = $batsmanId;
                $non_striker = $check_player['non_striker'];
            }
            $batsmanFound = true; 
        }
        elseif($batsman['_id'] == $bowlerId)
        {
            if($ball_status == "WD")
            {
                if($scoreInput == "0")
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + 1;
                    $bowler['ball_wides_bowled'] ++;
                    $totalteam2Score = $oldteam2Score + 1;
                }
                else
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + $scoreInput + 1;
                    $bowler['ball_wides_bowled'] ++;
                    $totalteam2Score = $oldteam2Score +  $scoreInput + 1;
                }
                $totalTeam2over = $oldteam2over;
            }
            elseif($ball_status == "NB")
            {
                if($scoreInput == "0")
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + 1;
                    $bowler['ball_no_bowl']++;
                    $totalteam2Score = $oldteam2Score + 1;   
                }
                else
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + $scoreInput + 1;
                    $bowler['ball_no_bowl']++;
                    $totalteam2Score = $oldteam2Score + $scoreInput + 1;
                }
                $totalTeam2over = $oldteam2over;
            }
            elseif($ball_status == "BYE")
            {
                if($scoreInput == "0")
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'];
                    $bowler['bye_run'] += $scoreInput;
                    $totalteam2Score = $oldteam2Score + 1;   
                }
                else
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + $scoreInput;
                    $bowler['bye_run'] += $scoreInput;
                    $totalteam2Score = $oldteam2Score + $scoreInput + 1;
                }
                $totalteam2Score = $oldteam2over;
            }
            else
            {
                $bowler['ball_liveRun'] += $scoreInput;
                if($bowler['ball_over']  * 10 % 10 < 5)
                {
                    $bowler['ball_over'] = round($bowler['ball_over'] + 0.1, 1);
                    $totalTeam2over = round($oldteam2over + 0.1,1);
                }
                else
                {
                    $bowler['ball_over'] =  round($bowler['ball_over'] + 0.5, 1);
                    $totalteam2Score = round($oldteam2over + 0.5,1);
                    if($scoreInput == "1" || $scoreInput == "3")
                    {
                        $striker = $batsmanId;
                        $non_striker = $check_player['non_striker'];
                    }
                    else
                    {
                        $striker = $check_player['non_striker'];
                        $non_striker = $batsmanId;
                    }
                }
            }
            $bowlerFound = true;    
        }
        $totalteam1Score = $oldScore + $scoreInput; 
    }

    $bowlerFound = false;
    foreach($check_player['team_2'] as &$bowler)
    {
        if($bowler['_id'] == $batsmanId)
        {

            if($scoreInput == "4" && $ball_status == "")
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_4'] ++;
                $batsman['bat_ball']++;
                $striker = $batsmanId;
                $non_striker =$check_player['non_striker'];
            }
            elseif($scoreInput == "6")
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_6'] ++;
                $batsman['bat_ball']++;
                $striker = $batsmanId;
                $non_striker =$check_player['non_striker'];
            }
            elseif($scoreInput == "1" && $ball_status == "")
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_ball'] ++;
                $striker = $check_player['non_striker'];
                $non_striker = $batsmanId;
            }
            elseif($scoreInput == "3" && $ball_status == "")
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_ball'] ++;
                $striker = $check_player['non_striker'];
                $non_striker = $batsmanId;
            }
            elseif($scoreInput == "0")
            {
                $batsman['bat_ball'] ++;
                $striker = $batsmanId;
                $non_striker = $check_player['non_striker'];
            }
            elseif($ball_status == "WD" && $scoreInput)
            {
                if($scoreInput == "1")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                elseif($scoreInput == "2")
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
                elseif($scoreInput == "3")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                else
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
            }
            elseif($ball_status == "NB" && $scoreInput)
            {
                if($scoreInput == "1" && $scoreInput == "3")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                else
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
            }
            elseif($ball_status == "LB" && $scoreInput)
            {
                if($scoreInput == "1" && $scoreInput == "3")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                else
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
            }
            elseif($ball_status == "BYE" && $scoreInput)
            {
                if($scoreInput == "1" && $scoreInput == "3")
                {
                    $striker = $check_player['non_striker'];
                    $non_striker = $batsmanId;
                }
                else
                {
                    $striker = $batsmanId;
                    $non_striker =$check_player['non_striker'];
                }
            } 
            else
            {
                $batsman['bat_liveRun'] += $scoreInput;
                $batsman['bat_ball'] ++;
                $striker = $batsmanId;
                $non_striker = $check_player['non_striker'];
            }
            $batsmanFound = true; 

        }
        elseif($bowler['_id'] == $bowlerId)
        {
            if($ball_status == "WD")
            {
                if($scoreInput == "0")
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + 1;
                    $bowler['ball_wides_bowled'] ++;
                    $totalteam1Score = $oldScore + 1;
                }
                else
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + $scoreInput + 1;
                    $bowler['ball_wides_bowled'] ++;
                    $totalteam1Score = $oldScore +  $scoreInput + 1;
                }
                $totalTeam1over = $oldover;
            }
            elseif($ball_status == "NB")
            {
                if($scoreInput == "0")
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + 1;
                    $bowler['ball_no_bowl']++;
                    $totalteam1Score = $oldScore + 1;   
                }
                else
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + $scoreInput + 1;
                    $bowler['ball_no_bowl']++;
                    $totalteam1Score = $oldScore + $scoreInput + 1;
                }
                $totalTeam1over = $oldover;
            }
            elseif($ball_status == "BYE" || $ball_status == "LB")
            {
                if($scoreInput == "0")
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'];
                    $bowler['bye_run'] += $scoreInput;
                    $totalteam1Score = $oldScore + 1;   
                }
                else
                {
                    $bowler['ball_liveRun'] = $bowler['ball_liveRun'] + $scoreInput;
                    $bowler['bye_run'] += $scoreInput;
                    $totalteam1Score = $oldScore + $scoreInput;
                }
                $totalTeam1over = $oldover;
                if($bowler['ball_over']  * 10 % 10 < 5)
                {
                    $bowler['ball_over'] = round($bowler['ball_over'] + 0.1, 1);
                    $totalTeam1over = round($oldover + 0.1,1);
                }
                else
                {
                    $bowler['ball_over'] =  round($bowler['ball_over'] + 0.5, 1);
                    $totalTeam1over = round($oldover + 0.5,1);
                    if($scoreInput == "1" || $scoreInput == "3")
                    {
                        $striker = $batsmanId;
                        $non_striker = $check_player['non_striker'];
                    }
                    else
                    {
                        $striker = $check_player['non_striker'];
                        $non_striker = $batsmanId;
                    }
                }
            }
            else
            {
                $bowler['ball_liveRun'] += $scoreInput;
                if($bowler['ball_over']  * 10 % 10 < 5)
                {
                    $bowler['ball_over'] = round($bowler['ball_over'] + 0.1, 1);
                    $totalTeam1over = round($oldover + 0.1,1);
                }
                else
                {
                    $bowler['ball_over'] =  round($bowler['ball_over'] + 0.5, 1);
                    $totalTeam1over = round($oldover + 0.5,1);
                    if($scoreInput == "1" || $scoreInput == "3")
                    {
                        $striker = $batsmanId;
                        $non_striker = $check_player['non_striker'];
                    }
                    else
                    {
                        $striker = $check_player['non_striker'];
                        $non_striker = $batsmanId;
                    }
                }
            }
            $bowlerFound = true;    
        }
        $totalteam2Score = $oldteam2Score + $scoreInput;
    }

    if($batsmanFound && $bowlerFound)
    {
        $response['status_code'] = '200';
        $response['batsman'] = $batsman;
        $response['bowler'] = $bowler;
        $response['over'] = $totalTeam1over;
        $response['message'] = 'Live run updated for batsman and bowler';
    } 
    else 
    {
        $response['status_code'] = '404';
        $response['message'] = 'Player(s) not found';
    }

    $document = [
        '$set' => [
            'team_1' => $check_player['team_1'],
            'team_2' => $check_player['team_2'],
            'team1_score' => $totalteam1Score,
            'striker' => $striker,
            'non_striker' => $non_striker,
            'team1_over' => $totalTeam1over,
        ]
    ];

    $updateRole = $matchCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($matchId)],
        $document);

    if($updateRole->getModifiedCount() <= 0)
    {
        $response['status_code'] = '400';
        $response['message'] = 'Player role update failed';
    }
}
else
{
    $response = [
        'status_code' => '404',
        'message' => 'record not found'
    ];
}

echo json_encode($response);
?>