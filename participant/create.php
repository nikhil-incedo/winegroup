<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../models/participant.php';
 
$database = new Database();
$db = $database->getConnection();
 
$participant = new Participant($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
if(empty($data->firstname) OR empty($data->lastname)) {
    echo '{';
        echo '"result": "failure"';
        echo '"message": "Invalid Data"';
    echo '}';
    exit();
}

// set participant property values
$participant->firstname = $data->firstname;
$participant->lastname = $data->lastname;
 
echo $participant->store();
exit();