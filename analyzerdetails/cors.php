<?php 
$url = $_POST["weburl"];
if(isset($url)) {
    $headers = getHeaders($url);
    header("Access-Control-Allow-Origin: *");

    if(count($headers) == 0) {
        die("Invalid request"); 
    } else {
        echo $headers[0];       
    }

    foreach($headers as $header) {
        if(strpos($header, "Access-Control") !== false) {
            echo " " . $header;
        }
    }
}

function getHeaders($url, $needle = false) {
    $headers = array();
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);        
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);               
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');    
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $header) use(&$headers) {
        array_push($headers, $header);
        return strlen($header);
    });
    curl_exec($ch);
    return $headers;
} 
?>