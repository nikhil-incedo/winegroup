<?php
class Event
{
    // database connection and table name
    private $conn;
    
    // object properties
    public $id;
    public $date;
    public $status;
 
    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    function list() {
        // select query
        $query = "SELECT id, date, status FROM events ORDER BY created_at DESC";
     
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
        $query = "INSERT INTO events SET date=:date";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->date=htmlspecialchars(strip_tags($this->date));
     
        // bind values
        $stmt->bindParam(":date", $this->date);

        // execute query
        if($stmt->execute()) {
            return true;
        }
     
        return false;
    }

    function update() {
        if(empty($this->date) AND empty($this->status)) {
            return true;
        }else {
            $allowedStatus = array('A','C','I');
            if(!empty($this->date)) {
                $updateArr[] = "date=:date";
            }
            if(!empty($this->status) AND in_array($this->status, $allowedStatus)) {
                $updateArr[] = "status=:status";
            }
            $query = "UPDATE events SET ";
            $query .= implode(',', $updateArr);
            $query .= " WHERE id=:id";

            $stmt = $this->conn->prepare($query);
            $this->id=htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(":id", $this->id);

            if(!empty($this->date)) {
                $this->date=htmlspecialchars(strip_tags($this->date));
                $stmt->bindParam(":date", $this->date);                
            }
            if(!empty($this->status)) {
                $this->status=htmlspecialchars(strip_tags($this->status));
                if(in_array($this->status, $allowedStatus)) {
                    $stmt->bindParam(":status", $this->status);                
                }
            }
        
           if($stmt->execute()) {
                return true;
            }

            return false;
        }
    }

}