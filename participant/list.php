<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/participant.php';
 
// instantiate database and participant object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$participant = new Participant($db);
 
// query products
$stmt = $participant->list();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0) {
 
    // products array
    $participantArr = array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to just $name only
        extract($row);
 
        $individual = array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "fullname" => ucwords($firstname . ' ' . $lastname)
        );
 
        array_push($participantArr, $individual);
    }
 
    echo json_encode($participantArr);
}
 
else {
    echo json_encode(
        array("message" => "No participant found.")
    );
}