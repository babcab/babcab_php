<?php
$rideFields = array (
    "id" => array(
        "name" => "id",
        "sql" => "id",
        "type" => 'int',
        "msg" => "Id is required!",
        "valMsg" => "Id is invalid!",
        "null" => false,
        "lwCase" => false
    ),
    "price" => array(
        "name" => "price",
        "sql" => "id",
        "type" => 'int',
        "msg" => "Price is required!",
        "valMsg" => "Price is invalid!",
        "null" => false,
        "lwCase" => false
    ),
    "seats" => array(
        "name" => "seats",
        "sql" => "seats",
        "type" => 'int',
        "msg" => "Seats is required!",
        "valMsg" => "Seats is invalid!",
        "null" => false,
        "lwCase" => false
    ),
    "ride_id" => array(
        "name" => "ride_id",
        "sql" => "id",
        "type" => 'int',
        "msg" => "Ride ID is required!",
        "valMsg" => "Ride ID is invalid!",
        "null" => false,
        "lwCase" => false
    ),
    "vehicle" => array(
        "name" => "vehicle",
        "sql" => "user_role",
        "type" => 'string',
        "msg" => "Vehicle is required!",
        "valMsg" => "Vechile should be one of these: Bike, Car, Bus, Van & Truck!",
        "null" => false,
        "lwCase" => true,
        "defaultValues" => ['bike', 'car', 'bus', 'van', 'truck']
    ),
    "time" => array(
        "name" => "time",
        "sql" => "id",
        "type" => 'time',
        "msg" => "Time is required!",
        "valMsg" => "Time is invalid!",
        "null" => false,
        "lwCase" => true
    ),
    "lat" => array(
        "name" => "lat",
        "sql" => "id",
        "type" => 'double',
        "msg" => "Latitude is required!",
        "valMsg" => "Latitude is invalid!",
        "null" => false,
        "lwCase" => true
    ),
    "lng" => array(
        "name" => "lng",
        "sql" => "lng",
        "type" => 'double',
        "msg" => "Longitude is required!",
        "valMsg" => "Longitude is invalid!",
        "null" => false,
        "lwCase" => true
    ),
    "city" => array (
        "name" => "city",
        "sql" => "user_City",
        "type" => 'string',
        "msg" => "City is required!",
        "null" => false,
        "lwCase" => true
    ),
    "state" => array (
        "name" => "state",
        "sql" => "user_City",
        "type" => 'string',
        "msg" => "State is required!",
        "null" => false,
        "lwCase" => true
    ),
    "country" => array (
        "name" => "country",
        "sql" => "user_Country",
        "type" => 'string',
        "msg" => "Country is required!",
        "null" => false,
        "lwCase" => true
    )
);