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
    "role" => array(
        "name" => "role",
        "sql" => "user_role",
        "type" => 'string',
        "msg" => "Role is required!",
        "valMsg" => "Role is invalid!",
        "null" => false,
        "lwCase" => true,
        "defaultValues" => ['driver', 'rider', 'both']
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
    "name" => array (
        "name" => "name",
        "sql" => "user_name",
        "type" => 'string',
        "msg" => "Name is required!",
        "null" => false,
        "lwCase" => true
    ),
    "email" => array (
        "name" => "email",
        "sql" => "user_email",
        "type" => 'email',
        "msg" => "Email is required!",
        "null" => false,
        "valMsg" => "Email is invalid!",
        "lwCase" => true
    ),
    "password" => array (
        "name" => "password",
        "sql" => "user_password",
        "type" => 'password',
        "msg" => "Password is required!",
        "null" => false,
        "valMsg" => "Password must be 8-12 characters",
        "lwCase" => false
    ),
    "phoneNumber" => array (
        "name" => "phoneNumber",
        "sql" => "user_phoneNumber",
        "type" => 'int',
        "msg" => "Phone number is required!",
        "valMsg" => "Phone number is invalid!",
        "null" => false,
        "lwCase" => false
    ),
    "college" => array (
        "name" => "college",
        "sql" => "user_college",
        "type" => 'string',
        "msg" => "College is required!",
        "null" => false,
        "lwCase" => false
    ),
    "address" => array (
        "name" => "address",
        "sql" => "user_address",
        "type" => 'string',
        "msg" => "Address is required!",
        "null" => false,
        "lwCase" => false
    ),
    "city" => array (
        "name" => "city",
        "sql" => "user_city",
        "type" => 'string',
        "msg" => "City is required!",
        "null" => false,
        "lwCase" => true
    ),
    "pincode" => array (
        "name" => "pincode",
        "sql" => "user_pincode",
        "type" => 'int',
        "msg" => "Pincode is required!",
        "valMsg" => "Pincode is invalid!",
        "null" => false,
        "lwCase" => false
    )
);