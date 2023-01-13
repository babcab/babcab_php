<?php
$rootDir = $_SERVER['DOCUMENT_ROOT'];

// Setup url route and it's variables
$request = $_SERVER['REQUEST_URI'];
$routerArr = parse_url(str_replace('/api/v1', '', $request));

$uri = $routerArr['path'];
parse_str(isset($routerArr['query']) ? $routerArr['query'] : '', $getArr);

$getArr = json_decode(json_encode($getArr));

// Including dependencies
require "$rootDir/../vendor/autoload.php";
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable("$rootDir/../");
$getenv = $dotenv->load();


// Including Files
require_once "$rootDir/../config/database.php";
require_once "$rootDir/../class/purifier.php";
require_once "$rootDir/../includes/function.php";
require_once "$rootDir/../class/auth.php";

// Creating Objects
$AuthObj = new Auth ();

// Declaring Variables
$isLoggedIn = $AuthObj->isLoggedIn();
$userRole = $AuthObj->isLoggedIn() ? $AuthObj->role() : '';
$userTokenData = $AuthObj->isLoggedIn() ? $AuthObj->getData()->data : array();
$errorCode = 400;
$data = json_decode(file_get_contents("php://input"));


// Including API's
try {

    require_once './controller/user.php';
    require_once './controller/ride.php';
    



    $errorCode = 400;
    throw new Exception('bad request!');

} catch (Exception $ex) {
    $errorCode = empty($errorCode) ? 500 : $errorCode;
    responseWithoutData($errorCode, $ex->getMessage());
}