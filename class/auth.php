<?php 
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth {
    private $token = '';
    public $loggedIn = false;
    public $decodedData;
    public $role;

    private $secret;

    public function __construct () {
        $this->getEvn();

        if (!empty($_COOKIE['token'])) {
            $this->token = htmlspecialchars($_COOKIE['token']);
        }

        if (!empty($_GET['token'])) {
            $this->token = htmlspecialchars($_GET['token']);
        }

        try {
            $this->decodedData = JWT::decode($this->token, new Key($this->getenv['JWT_SECRET'], 'HS512'));


            if (isset($this->decodedData->data)) {
                $this->role = $this->decodedData->data->role == $this->getenv['ADMIN'] ? 'admin' : 'user';
                $this->loggedIn = true;
            }

        } catch (Exception $ex) {
            $this->loggedIn = false;
        }
    }

    private function getEvn () {
        $this->getenv = $GLOBALS['getenv'];
    }

    public function isLoggedIn () {
        return $this->loggedIn;
    }

    public function isAdmin () {
        return $this->role == 'admin' ? 1 : 0;
    }

    public function role () {
        return $this->role;
    }

    public function getData () {
        return $this->decodedData;
    }
}


?>