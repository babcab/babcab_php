<?php
require "$rootDir/../vendor/autoload.php";
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable("$rootDir/../");
$getenv = $dotenv->load();

require_once "$rootDir/../class/auth.php";


$AuthObj = new Auth ();

if (!$AuthObj->isLoggedIn()) {
    header("Location: /login.php");
    die();
}

$role = $AuthObj->role();

if ($role != 'admin') {
    header("Location: /login.php");
    die();
}
?>