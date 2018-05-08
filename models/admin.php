<?php
class Admin
{
    // database connection and table name
    private $conn;
 
    // object properties
    public $id;
    public $password;
    public $token;
 
    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    function login() {
        $query = "SELECT id FROM admins WHERE password=:password";
        $stmt = $this->conn->prepare($query);
        
        $this->password=htmlspecialchars(strip_tags($this->password));
        $stmt->bindParam(":password", $this->password);

        // execute query
        if($stmt->execute()) {
            if($stmt->rowCount()>0) {
                if($this->setToken($this->conn->lastInsertId())) {
                    $ret['result'] = 'success';
                    $ret['token'] = $this->token;
                    return json_encode($ret);
                }
            }
        }

        $ret['result'] = 'failure';
        $ret['message'] = 'Wrong Password';
        
        return json_encode($ret);
    }

    private function setToken($id)
    {
        $token = md5(strtotime('now'));
        $query = "UPDATE admins SET token=:token WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":id", $id);

        if($stmt->execute()) {
            $this->token = $token;
            return true;
        }
        return false;
    }
}