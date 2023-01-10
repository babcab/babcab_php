<?php
use \Firebase\JWT\JWT;

class User {
    public $id;
    public $name;
    public $phoneNumber;
    public $email;
    public $college;
    public $graduated;
    public $address;
    public $city;
    public $pincode;
    public $password;

    public $conditions = [
        "limit" => -1,
        "currPage" => 1
    ];
    public $charType = [
        "int" => "i",
        "string" => "s",
        "boolean" => "i",
        "email" => "s",
        "password" => "s",
    ];

    private $tbName = 'user';
    private $conn;

    public function __construct ($db, $table) {
        $this->conn = $db;
        $this->table = $table;
    }

    public function create () {
        try {
            $query = "INSERT INTO ".$this->tbName." set user_name = ?, user_phoneNumber = ?, user_password = ?, user_email = ?, user_college = ?, graduated = ?, user_address = ?, user_city = ?, user_pincode = ?, user_role = ?";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("sssssissis", $this->data['name'], $this->data['phoneNumber'], $this->data['password'], $this->data['email'], $this->data['college'], $this->data['graduated'], $this->data['address'], $this->data['city'], $this->data['pincode'], $this->data['role']);
            
            if ($obj->execute()) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function get ($id) {
        try {
            $query = "SELECT * from ".$this->tbName." WHERE id = ?";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("i", $id);
            
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

    public function gets () {
        $limit = $this->conditions['limit'];
        $offset = ($this->conditions['currPage'] - 1) * $limit;
        $totalUser = $this->count();
        $role = $this->conditions['role'];

        try {
            if ($limit == -1) {
                if (empty($role)) {
                    $query = "SELECT id, user_name, user_role, user_phoneNumber, user_email, user_college, graduated, user_address, user_city, user_pincode
                    from ".$this->tbName."
                    ORDER BY id DESC";  
                } else {
                    $query = "SELECT id, user_name, user_role, user_phoneNumber, user_email, user_college, graduated, user_address, user_city, user_pincode
                    from ".$this->tbName." WHERE user_role = ?
                    ORDER BY id DESC";  
                }
            } else {
                if (empty($role)) {
                    $query = "SELECT id, user_name, user_role, user_phoneNumber, user_email, user_college, graduated, user_address, user_city, user_pincode
                    from ".$this->tbName."
                    ORDER BY id DESC LIMIT {$offset}, {$limit}";  
                } else {
                    $query = "SELECT id, user_name, user_role, user_phoneNumber, user_email, user_college, graduated, user_address, user_city, user_pincode
                    from ".$this->tbName."  WHERE user_role = ?
                    ORDER BY id DESC LIMIT {$offset}, {$limit}";  
                }
            }

            
            $obj = $this->conn->prepare($query);

            if (!empty($role)) $obj->bind_param('s', $role);
            
            if ($obj->execute()) {
                $data = $obj->get_result();

                $this->fetchData ($data);

                return array(
                    'totalUser' => $totalUser,
                    'limit' => $limit,
                    "currPage" => $this->conditions['currPage'],
                    'users' => $this->data
                );
            }

            return array();
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        } 
    }

    public function count () {
        try {
            $role = $this->conditions['role'];

            if (empty($role)) {
                $query = "SELECT COUNT(id) as total from ".$this->tbName;
            } else {
                $query = "SELECT COUNT(id) as total from ".$this->tbName." WHERE user_role = ?";
            }
            
            $obj = $this->conn->prepare($query);

            if (!empty($role)) $obj->bind_param("s", $role);
            
            if ($obj->execute()) {
                $data = $obj->get_result();

                $this->fetchData ($data);

                return $this->data[0]['total'];
            }

            return array();
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }


    public function getByEmail ($email) {
        try {
            $query = "SELECT * from ".$this->tbName." WHERE user_email = ?";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("s", $email);
            
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



    public function getByPhone ($ph) {
        try {
            $query = "SELECT * from ".$this->tbName." WHERE phoneNumber = ?";
            
            $obj = $this->conn->prepare($query);

            $obj->bind_param("s", $ph);
            
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


    public function update () {
        try {
            $query = "UPDATE ".$this->tbName."  set user_name = ?, graduated = ?, user_address = ?, user_city = ?, user_pincode = ? WHERE id = ?";

            $obj = $this->conn->prepare($query);

            $obj->bind_param("sissii", $this->data['name'], $this->data['graduated'], $this->data['address'], $this->data['city'], $this->data['pincode'], $this->data['id']);
            
            if ($obj->execute()) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function delete ($id) {
        $query = "DELETE FROM ".$this->tbName." WHERE id = ?";
        
        $obj = $this->conn->prepare($query);

        $obj->bind_param("i", $id);

        if ($obj->execute()) {
            return true;
        }

        return false;
    }

    public function alreadyExists ($name) {
        try {
            $query = "SELECT * FROM ".$this->tbName." WHERE ".$this->table[$name]['sql']." = ?";
            $obj = $this->conn->prepare($query);

            $obj->bind_param($this->charType[$this->table[$name]['type']], $this->data[$name]);

            if($obj->execute()) {
                $data = $obj->get_result();

                return  $data->num_rows < 1 ? false : true;
            }

            return false; 
        } catch (Exception $ex) {
            throw new Exception ($ex->getMessage());
        }
    }

    public function generateJWT ($getenv) {
        $iss = "localhost";
        $iat = time();
        $nbf = $iat;
        $exp = $iat + (86400 * $getenv["JWT_EXPIRES_IN"]);
        $aud = "myusers";

        $userArrData = array(
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "role" => $this->role,
            "graduated" => $this->graduated
        );
        
        $payloadInfo = array (
            "iss" => $iss,
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $exp,
            "aud" => $aud,
            "data" => $userArrData
        );

        $jwt = JWT::encode($payloadInfo, $getenv["JWT_SECRET"], 'HS512');

        return $jwt;
    }

    public function fetchData ($data) {
        $obj = [];

        while ($row = mysqli_fetch_assoc($data)) {
            array_push($obj, $row);
        }

        $this->data = $obj;
    }
} 

?>