<?php
// Including files
require_once "$rootDir/../class/ride.php";
require_once "$rootDir/../table/ride.php";

// Creating objects
$rideObj = new Ride ($conn, $rideFields);
$purifierObj = new Purifier ($data);

if ($uri == '/create-ride') {
    if ($_SERVER["REQUEST_METHOD"] != 'POST') throw new Exception ('Bad Request!');

    if (!$isLoggedIn || !in_array($userRole, ['driver', 'admin', 'both'])) throw new Exception ("Access Denied!");

    $valArr = ['seats', 'price', 'time'];
    foreach($valArr as $el) {
        $filteredObj[$el] = $purifierObj->start($rideFields[$el]);
    }

    if (empty($data->checkPoints) || sizeof($data->checkPoints) < 2) throw new Exception ("Set minimum 2 checkpoints!");

    $latLng = [];
    $cities = [];
    $state = [];
    $country = [];

    foreach($data->checkPoints as $el) {
        $purifierObj->data = $el;

        $tempLat = $purifierObj->start($rideFields['lat']);
        $tempLng = $purifierObj->start($rideFields['lng']);
        $tempCity = $purifierObj->start($rideFields['city']);
        $tempState = $purifierObj->start($rideFields['state']);
        $tempCountry = $purifierObj->start($rideFields['country']);

        array_push($latLng, array(
            "lat" => $tempLat,
            "lng" => $tempLng
        ));

        array_push($cities, $tempCity);
        array_push($state, $tempState);
        array_push($country, $tempCountry);
    }

    $rideObj->cities = join(" | ", generateCombination($cities));
    $rideObj->states = join(" | ", generateCombination($state));
    $rideObj->countries = join(" | ", generateCombination($country));
    $rideObj->latLng = json_encode($latLng);
    $rideObj->timeStamp = $filteredObj['time'];
    $rideObj->seats = $filteredObj['seats'];
    $rideObj->price = $filteredObj['price'];
    $rideObj->driver_id = $userTokenData->id;

    if ($rideObj->createRide()) {
        responseWithoutData(200, "Ride created successfully!");
        die();
    }

    responseWithoutData(500, "Something went wrong, try again!");
    die();
} else if ($uri == '/search-ride') {

    if (empty($data->from) || empty($data->to)) throw new Exception ("All Fields are required!");

    $listArr = ['from', 'to'];
    $cities = [];
    $state = [];
    $country = [];

    foreach($listArr as $el) {
        $purifierObj->data = $data->{$el};

        $tempLat = $purifierObj->start($rideFields['lat']);
        $tempLng = $purifierObj->start($rideFields['lng']);
        $tempCity = $purifierObj->start($rideFields['city']);
        $tempState = $purifierObj->start($rideFields['state']);
        $tempCountry = $purifierObj->start($rideFields['country']);

        array_push($cities, $tempCity);
        array_push($state, $tempState);
        array_push($country, $tempCountry);
    }
    // $listArr = function

    $rideObj->cities = $cities[0]."-".$cities[1];
    $rideObj->states = $state[0]."-".$state[1];
    $rideObj->countries = $country[0]."-".$country[1];

    responseWithData($rideObj->searchRide());
    die();
} else if ($uri == '/join-ride') {
    if ($_SERVER["REQUEST_METHOD"] != 'POST') throw new Exception ('Bad Request!');

    if (!$isLoggedIn || !in_array($userRole, ['rider', 'admin', 'both'])) throw new Exception ("Access Denied!");

    $valArr = ['ride_id', 'seats'];
    foreach($valArr as $el) {
        $filteredObj[$el] = $purifierObj->start($rideFields[$el]);
    }

    $rideObj->ride_id = $filteredObj['ride_id'];
    $rideObj->seats = $filteredObj['seats'];

    $availableSeats = $rideObj->getAvailableSeats();

    if ($availableSeats < $filteredObj['seats']) throw new Exception ('Seats not available!');

    $rideObj->rider_id = $userTokenData->id;

    if ($rideObj->joinRide()) {
        responseWithoutData(200, "Ride Joined!");
        die();
    }

    responseWithoutData(500, "Something went wrong, try again!");
    
    die();
}  else if ($uri == '/update-ride') {
    if ($_SERVER["REQUEST_METHOD"] != 'POST') throw new Exception ('Bad Request!');
    if (empty($data)) throw new Exception ('Fields are required');
    if (!$isLoggedIn) throw new Exception ('Access Denied!');

    $rideObj->postData['id'] = $purifierObj->start($rideFields['id']);
    $oldRideData = $rideObj->getBy('id')[0];

    $valuesArr = ['seats'];

    foreach($valuesArr as $el) {
        $filteredObj[$el] = isset($data->{$el}) ? $purifierObj->start($rideFields[$el]) : $oldRideData[$rideFields[$el]['sql']];
    }

    $filteredObj['id'] = $oldRideData['id'];
    $rideObj->data = $filteredObj;
    
    if ($rideObj->updateRide()) {
        responseWithoutData(200, "Ride updated successfully!");
        die();
    }

    responseWithoutData(500, "Something went wrong, try again!");
    die();
}



?>