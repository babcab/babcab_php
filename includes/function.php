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

function generateCombination ($arr) {
    $tempArr = [];
    for($i = 0; $i < sizeof($arr); $i++) {
        for ($j = $i; $j < sizeof($arr); $j++) {
            if ($i > 0 && $i == $j) {
                // Skip
            } else {
                if (!(sizeof($tempArr) < 1)) {
                    $lastElment = $tempArr[sizeof($tempArr)-1];
                    $x = $arr[$i]."-".$arr[$j];

                    if ($lastElment != $x) array_push($tempArr, $x);

                } else {
                    array_push($tempArr,  $arr[$i]."-".$arr[$j]);
                }
            }
        }
    }
    return $tempArr;
}

?>