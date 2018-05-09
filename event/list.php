<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/event.php';
 
$database = new Database();
$db = $database->getConnection();
 
$event = new Event($db);
 
$stmt = $event->list();
$num = $stmt->rowCount();
 
if($num>0) {
    $eventArr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
    
        $datum = array(
            "id" => $id,
            "date" => $date,
            "status" => $status
        );
 
        array_push($eventArr, $datum);
    }
 
    echo json_encode($eventArr);
} else {
    echo json_encode(
        array("message" => "No event found.")
    );
}