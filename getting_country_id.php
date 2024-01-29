<?php 

    $data = json_decode(file_get_contents('php://input'), true);

    $country_id = $data['country_id'];

    $response = array(
        'data' => $country_id
    );

    echo json_encode($response, JSON_PRETTY_PRINT);

    

?>