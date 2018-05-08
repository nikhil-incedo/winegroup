<?php
class Participant
{
 
    // database connection and table name
    private $conn;
    private $table_name = "participants";
 
    // object properties
    public $id;
    public $firstname;
    public $lastname;
 
    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    function list() {
        // select query
        $query = "SELECT id, firstname, lastname FROM " . $this->table_name . " ORDER BY firstname, lastname";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function show() {

    }

    function store() {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET firstname=:firstname, lastname=:lastname";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname  = htmlspecialchars(strip_tags($this->lastname));
     
        // bind values
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);

        // execute query
        if($stmt->execute()) {
            $ret['result']  = 'success';
            $ret['id']      = $this->conn->lastInsertId();
        }else {
            $ret['result']  = 'failure';
            $ret['message'] = 'Unable to save';
        }
    
        return json_encode($ret);
    }

    function update() {

    }

}