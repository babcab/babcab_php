<?php

if ($uri == '/testing') {
    $curl = curl_init();
    
// create curl resource 
$ch = curl_init(); 
// set url 
curl_setopt($ch, CURLOPT_URL, "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=30.356962&lon=76.419693"); 
//return the transfer as a string 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// $output contains the output string 
$output = curl_exec($ch); 
echo($output);
// close curl resource to free up system resources 
curl_close($ch); 

    die();
}

// function geocode($lat, $lng){

    // url encode the address
    // $address = urlencode($address);

    // $url = "http://nominatim.openstreetmap.org/?format=json&addressdetails=1&q={$address}&format=json&limit=1";
    $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=".urlencode(30.356962)."&lon=".urlencode(76.419693)."";

    //call api
    $json = file_get_contents($url);
    $json = json_decode($json);
    print_r($json);
    
    // get the json response
    // $resp_json = file_get_contents($url);
    // print_r($resp_json);

    // // decode the json
    // $resp = json_decode($resp_json, true);

    // // return array($resp[0]['lat'], $resp[0]['lon']);
    // print_r($resp);

// }