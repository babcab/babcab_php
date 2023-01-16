<?php
$userFields = array (
    "id" => array(
        "name" => "id",
        "sql" => "id",
        "type" => 'int',
        "msg" => "Id is required!",
        "valMsg" => "Id is invalid!",
        "null" => false,
        "lwCase" => false
    ),
    "name" => array (
        "name" => "name",
        "sql" => "name",
        "type" => 'string',
        "msg" => "Name is required!",
        "null" => false,
        "lwCase" => true
    ),
    "role" => array(
        "name" => "role",
        "sql" => "role",
        "type" => 'string',
        "msg" => "Role is required!",
        "valMsg" => "Role is invalid!",
        "null" => false,
        "lwCase" => true,
        "defaultValues" => ['driver', 'rider', 'both']
    ),
    "vehicle" => array(
        "name" => "vehicle",
        "sql" => "vehicle",
        "type" => 'string',
        "msg" => "Vehicle name is required!",
        "valMsg" => "Vechile name should be one of these: Bike, Car, Bus, Van & Truck!",
        "null" => false,
        "lwCase" => true,
        "defaultValues" => ['bike', 'car', 'bus', 'van']
    ),
    "vehicle_no" => array(
        "name" => "vehicle_no",
        "sql" => "vehicle_no",
        "type" => 'string',
        "msg" => "Vehicle number is required!",
        "valMsg" => "Vehicle no. is invalid!",
        "null" => false,
        "lwCase" => false
    ),



    "phoneNumber" => array (
        "name" => "phoneNumber",
        "sql" => "phone_no",
        "type" => 'int',
        "msg" => "Phone number is required!",
        "valMsg" => "Phone number is invalid!",
        "null" => false,
        "lwCase" => false
    ),
    "email" => array (
        "name" => "email",
        "sql" => "email",
        "type" => 'email',
        "msg" => "Email is required!",
        "null" => false,
        "valMsg" => "Email is invalid!",
        "lwCase" => true
    ),
    "password" => array (
        "name" => "password",
        "sql" => "password",
        "type" => 'password',
        "msg" => "Password is required!",
        "null" => false,
        "valMsg" => "Password must be 8-12 characters",
        "lwCase" => false
    ),
    "college" => array (
        "name" => "college",
        "sql" => "college",
        "type" => 'string',
        "msg" => "College is required!",
        "null" => false,
        "lwCase" => false
    ),
    "graduated" => array (
        "name" => "graduated",
        "sql" => "graduated",
        "type" => 'boolean',
        "msg" => "Graduated field is required!",
        "valMsg" => "Graduated should be true or false!",
        "null" => false,
        "lwCase" => true,
        "defaultValues" => ['true', 'false']
    ),
    "address" => array (
        "name" => "address",
        "sql" => "address",
        "type" => 'string',
        "msg" => "Address is required!",
        "null" => false,
        "lwCase" => false
    ),
    "city" => array (
        "name" => "city",
        "sql" => "city",
        "type" => 'string',
        "msg" => "City is required!",
        "null" => false,
        "lwCase" => true
    ),
    "pincode" => array (
        "name" => "pincode",
        "sql" => "pincode",
        "type" => 'int',
        "msg" => "Pincode is required!",
        "valMsg" => "Pincode is invalid!",
        "null" => false,
        "lwCase" => false
    )
);