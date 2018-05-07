<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../models/event.php';
 
$database = new Database();
$db = $database->getConnection();
 
$event = new Event($db);
 
$data = json_decode(file_get_contents("php://input"));
if(empty($data->date)) {
    echo '{';
        echo '"message": "Invalid Data"';
    echo '}';
    exit();
}

$event->date = $data->date;
 
if($event->store()) {
    echo '{';
        echo '"message": "Event created successfully."';
    echo '}';
    exit();
} else {
    echo '{';
        echo '"message": "Unable to create event."';
    echo '}';
    exit();
}