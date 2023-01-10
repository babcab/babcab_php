<?php

function responseWithData ($arr) {

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode(array(
        "status" => "success",
        "data" => $arr
    ));
}

function responseMsgAndData ($msg, $arr) {

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode(array(
        "status" => "success",
        "message" => $msg,
        "data" => $arr
    ));
}

function responseWithoutData ($code, $msg) {
    $status = "fail";

    if ($code == 200) $status = "success";
    
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($code);
    echo json_encode(array(
        "status" => $status,
        "message" => $msg
    ));
}

function filter_text ($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>