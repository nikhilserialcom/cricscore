<?php
   require 'partials/mongodbconnect.php';
    // require 'getting_country_id.php';

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("content-type: application/json");

    
    $data = json_decode(file_get_contents('php://input'), true);


    $city_input = $data['city_input'];
    $state_id = $data['state_id'];
    // echo $city_input;

    // $response = array(
    //     'cityname' => $city_input,
    //     'state_id' => $state_id
    // );
    
    // echo json_encode($response,JSON_PRETTY_PRINT);

   if ($city_input == '') {
        $response = array(
            'status_code' => '404',
            'message' => 'Please enter 1 or more characters.'
        );

        echo json_encode($response,JSON_PRETTY_PRINT);
   }

   $filter = [
        'state_id' => $state_id,
        'city_name' => ['$regex' => '.*' . $city_input . '.*', '$options' => 'i']
    ];
    $options = ['sort' => ['city_name' => 1]];
   $check_city = $cityNameCollection->find($filter,$options);

   $arr_of_obj = [];

   foreach($check_city as $document)
   {
        $city_data = [
            'id' => $document['_id'],
            'city' => $document['city_name'],
        ];

        $arr_of_obj[] = $city_data;
   }

   if (!empty($arr_of_obj)) 
   {
        $response = [
            'status_code' => '200',
            'arr' => $arr_of_obj
        ];

        echo json_encode($response,JSON_PRETTY_PRINT);
   } 
   else 
   {
        $response = [
            'status_code' => 404,
            'message' => 'No result found'
        ];

        echo json_encode($response,JSON_PRETTY_PRINT);
   }
   

?>
