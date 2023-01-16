<?php
// Including files
require_once "$rootDir/../class/user.php";
require_once "$rootDir/../table/user.php";

// Creating objects
$userObj = new User ($conn, $userFields);
$purifierObj = new Purifier ($data);

if ($uri == '/create-user') {
    if ($_SERVER["REQUEST_METHOD"] != 'POST') throw new Exception ('Bad Request!');
    
    $valuesArr = ['graduated', 'name', 'vehicle', 'vehicle_no', 'email', 'password', 'phoneNumber', 'college', 'address', 'city', 'pincode', 'role'];

    foreach($valuesArr as $el) {
        $filteredObj[$el] = $purifierObj->start($userFields[$el]);
    }

    $userObj->data = $filteredObj;
 
    // Check if Phone Or email already Exists
    if ($userObj->alreadyExist('email') || $userObj->alreadyExist('phoneNumber')) throw new Exception ("Phone number or Email already in use");
    if ($userObj->alreadyExist('vehicle_no'))throw new Exception ("Vehicle already in use");

    if ($userObj->create()) {
        $userData = $userObj->getByEmail($filteredObj['email']);

        $userObj->id = $userData[0]['id'];
        $userObj->name = $userData[0]['name'];
        $userObj->email = $userData[0]['email'];
        $userObj->role = $userData[0]['role'];
        $userObj->graduated = $userData[0]['graduated'];
        $jwt = $userObj->generateJWT($getenv);

        setcookie('token', $jwt,  time() + (86400 * $getenv["JWT_COOKIE_EXPIRES_IN"]), '/');

        responseMsgAndData ('User created successfully!', array(
            "token" => $jwt 
        ));
        die();
    }

    responseWithoutData(200, "Something went wrong, try again!");
    die();


} else if ($uri == '/login') {
    if ($_SERVER["REQUEST_METHOD"] != 'POST') throw new Exception ('Bad Request!');

    $valuesArr = ['email'];

    foreach($valuesArr as $el) {
        $filteredObj[$el] = $purifierObj->start($userFields[$el]);
    }

    if (!isset($data->password) || empty($data->password)) throw new Exception ("Password is required!");

    $userData = $userObj->getByEmail($filteredObj['email']);

    if (empty($userData) || !password_verify($data->password, $userData[0]['password'])) throw new Exception ("Email or Password is incorrect!");
    
    $userObj->id = $userData[0]['id'];
    $userObj->name = $userData[0]['name'];
    $userObj->email = $userData[0]['email'];
    $userObj->role = $userData[0]['role'];
    $userObj->graduated = $userData[0]['graduated'];
    
    $jwt = $userObj->generateJWT($getenv);

    setcookie('token', $jwt,  time() + (86400 * $getenv["JWT_COOKIE_EXPIRES_IN"]), '/');
    responseMsgAndData('Logged in successfully!', array(
        "token" => $jwt 
    ));
    die();


} else if ($uri == '/logout') {
    http_response_code(200);
    setcookie('token', 'loggedout',  time() + 1, '/');

    echo json_encode(array(
        "status" => "success"
    ));

    header("Location: /login.php");
    die();
} else if ($uri == '/get-me') {
    if ($_SERVER["REQUEST_METHOD"] != 'GET') throw new Exception ('Bad Request!');

    if (!$isLoggedIn) throw new Exception ('Access Denied!');

    $userData = $userObj->get($userTokenData->id)[0];

    if (!empty($userData)) {
        responseWithData($userData);
        die();
    }

    responseWithoutData(500, "Something went wrong, try again!");
    die();


} else if ($uri == '/update-user') {
    if ($_SERVER["REQUEST_METHOD"] != 'POST') throw new Exception ('Bad Request!');

    if (!$isLoggedIn) throw new Exception ('Access Denied!');

    $userData = $userObj->get($userTokenData->id)[0];

    $valuesArr = ['name', 'graduated', 'address', 'city', 'pincode'];

    foreach($valuesArr as $el) {
        $filteredObj[$el] = isset($data->{$el}) ? $purifierObj->start($userFields[$el]) : $userData[$userFields[$el]['sql']];
    }

    $filteredObj['id'] = $userData['id'];
    $userObj->data = $filteredObj;

    if ($userObj->update()) {
        responseWithoutData(200, "User updated successfully!");
        die();
    }

    responseWithoutData(500, "Something went wrong, try again!");
    die();


} else if ($uri == '/get-all-user') {
    if ($_SERVER["REQUEST_METHOD"] != 'GET') throw new Exception ('Bad Request!');

    if (!$isLoggedIn || $userRole != 'admin') throw new Exception ('Access Denied!');

    $conditions = [
        "limit" => -1,
        "currPage" => 1,
        "role" => ['driver', 'rider', 'both']
    ];
    
    $conditions['limit'] = (isset($getArr->limit) && !empty($getArr->limit) && filter_var($getArr->limit, FILTER_VALIDATE_INT) && ($getArr->limit >=-1)) ? $getArr->limit : $conditions['limit'];
    $conditions['currPage'] = (isset($getArr->currPage) && !empty($getArr->currPage) && filter_var($getArr->currPage, FILTER_VALIDATE_INT)) ? $getArr->currPage : $conditions['currPage'];
    $conditions['role'] = (isset($getArr->role) && !empty($getArr->role) && filter_var($getArr->role, FILTER_SANITIZE_STRING) && in_array($getArr->role, $conditions['role']) ) ? filter_var($getArr->role, FILTER_SANITIZE_STRING) : "";

    $userObj->conditions = $conditions;
    responseWithData($userObj->gets());
    die();

} else if ($uri == '/delete-user') {
    if ($_SERVER["REQUEST_METHOD"] != 'GET') throw new Exception ('Bad Request!');

    if (!$isLoggedIn || $userRole != 'admin') throw new Exception ('Access Denied!');

    $purifierObj->data = $getArr;

    $userId = $purifierObj->start($userFields['id']);

    if ($userObj->delete($userId)) {
        responseWithoutData(200, 'Deleted Successfully');
        die();
    }

    responseWithoutData(500, 'Something went wrong');
    die();


} else if ($uri == '/check-phonenumber') {
    if ($_SERVER["REQUEST_METHOD"] != 'POST') throw new Exception ('Bad Request!');

    $filteredObj['phoneNumber'] = $purifierObj->start($userFields['phoneNumber']);
    $userObj->data = $filteredObj;

    if ($userObj->alreadyExist('phoneNumber')) {
        responseWithData(array("phoneNumberExist" => true));
        die();
    }

    responseWithData(array("phoneNumberExist" => false));
    die();
}
