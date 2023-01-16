<?php
class Ride {
    public $cities;
    public $states;
    public $countries;
    public $latLng;
    public $timeStamp;
    public $seats;
    public $price;
    public $vehicle;
    public $driver_id;
    public $rider_id;
    public $postData = [];

    private $tbName = 'rides';
    private $joinRideTb = 'join_rides';
    private $conn;

    public $charType = [
        "int" => "i",
        "string" => "s",
        "boolean" => "i",
        "email" => "s",
        "password" => "s",
    ];

    public function __construct ($db, $table) {
        $this->conn = $db;
        $this->table = $table;
    }

    public function createRide () {
        try {
            $query = "INSERT INTO ".$this->tbName."
             set driver_id = ?, ride_on = ?, ride_latlng = ?, ride_city = ?, ride_state = ?, ride_country = ?, ride_time = ?, ride_price = ?, ride_seats = ?, available_seats = ?";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("issssssiii", $this->driver_id, $this->vehicle ,$this->latLng, $this->cities, $this->states, $this->countries, $this->timeStamp, $this->price, $this->seats, $this->seats);
            
            if ($obj->execute()) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function searchRide () {
        try {
            $query = "SELECT * from ".$this->tbName." 
            WHERE ride_status = 0
                AND available_seats > 0
                AND ride_city LIKE CONCAT( '%',?,'%') 
                AND ride_state LIKE CONCAT( '%',?,'%')
                AND ride_country LIKE CONCAT( '%',?,'%')
            ";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("sss", $this->cities, $this->states, $this->countries);

            if ($obj->execute()) {
                $data = $obj->get_result();

                $this->fetchData ($data);

                return $this->data;
            }

            return array();
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function updateRide () {
        try {
            $query = "UPDATE ".$this->tbName."  set seats = ? WHERE id = ?";

            $obj = $this->conn->prepare($query);

            $obj->bind_param("si", $this->data['seats'], $this->data['id']);
            
            if ($obj->execute()) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function getAvailableSeats () {
        try {
            $query = "SELECT ride_seats from ".$this->tbName." 
                WHERE ride_id = ?
            ";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("i", $this->ride_id);

            if ($obj->execute()) {
                $data = $obj->get_result();

                $this->fetchData ($data);

                return isset($this->data[0]['ride_seats']) ? $this->data[0]['ride_seats'] : 0;
            }

            return 0;
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        } 
    }

    public function joinRide () {
        try {
            $query = "INSERT INTO ".$this->joinRideTb." 
                SET ride_id = ?, rider_id = ?, seats = ?
            ";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("iii", $this->ride_id, $this->rider_id, $this->seats);

            if ($obj->execute()) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        } 
    }

    public function alreadyJoinedRide () {
        try {
            $query = "SELECT * from ".$this->joinRideTb." 
                SET ride_id = ?, rider_id = ?, seats = ?
            ";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("iii", $this->ride_id, $this->rider_id, $this->seats);

            if ($obj->execute()) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        } 
    }

    public function getBy ($fieldName) {
        try {
            $query = "SELECT *
            from ".$this->tbName." WHERE ".$this->table[$fieldName]['sql']." = ?";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("i", $id);
            $obj->bind_param($this->charType[$this->table[$fieldName]['type']], $this->postData[$fieldName]);

            
            if ($obj->execute()) {
                $data = $obj->get_result();

                $this->fetchData ($data);

                if (empty($this->data)) throw new Exception ("No ride found!");

                return $this->data;
            }
            
            return array();
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function fetchData ($data) {
        $obj = [];

        while ($row = mysqli_fetch_assoc($data)) {
            if (isset($row['ride_latlng'])) $row['ride_latlng'] = json_decode($row['ride_latlng']);
            array_push($obj, $row);
        }

        $this->data = $obj;
    }
}

?>