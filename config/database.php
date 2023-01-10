<?php
class Database {
    private $hostname;
    private $dbname;
    private $username;
    private $passowrd;
    private $conn;

    public function __construct () {
        $this->getVariables();
    }

    public function connect () {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
        
        if ($this->conn->connect_errno) {
            print_r($this->conn->connect_error);
            exit;
        } else {
            return $this->conn;
        }
    }

    private function getVariables () {
        $this->getenv = $GLOBALS['getenv'];
        
        // Variable Initialization
        $this->hostname = $this->getenv["HOSTNAME"];
        $this->dbname = $this->getenv["DB_NAME"];
        $this->username = $this->getenv["USERNAME"];
        $this->password = $this->getenv["PASSWORD"];
    }
}

$dbObj = new Database();
$conn = $dbObj->connect();
?>