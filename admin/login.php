<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/admin.php';
 
$data = json_decode(file_get_contents("php://input"));

if(empty($data->password)) {
    echo '{';
        echo '"result": "failure",';
        echo '"message": "Invalid Data"';
    echo '}';
    exit();
}

$database = new Database();
$db = $database->getConnection();
$admin = new Admin($db);
$admin->password = $data->password;

echo $admin->login();
exit();