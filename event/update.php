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
if(empty($data->id)) {
    echo '{';
        echo '"message": "Invalid Data"';
    echo '}';
    exit();
}

$event->id = $data->id;
if(!empty($data->date)) {
    $event->date = $data->date;
}
if(!empty($data->status)) {
    $event->status = $data->status;
}

if($event->update()) {
    echo '{';
        echo '"message": "Event updated successfully."';
    echo '}';
    exit();
} else {
    echo '{';
        echo '"message": "Unable to update Event."';
    echo '}';
    exit();
}