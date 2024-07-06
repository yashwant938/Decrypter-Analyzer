<?php
require_once "../includes/functions.php";

$weburl=$_POST["weburl"];
$ch = curl_init();
$headers = [];
curl_setopt($ch, CURLOPT_URL, $weburl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HEADERFUNCTION,
  function($curl, $header) use (&$headers)
  {
    $len = strlen($header);
    $header = explode(':', $header, 2);
    if (count($header) < 2) 
      return $len;

    $headers[strtolower(trim($header[0]))][] = trim($header[1]);

    return $len;
  }
);

$data = curl_exec($ch);
echo "<h2>Server Info</h2>";

$dnsr = dns_get_record(get_domain($weburl), DNS_A + DNS_NS);

if(isset($dnsr[0]["ip"])){
  echo "IP: ".$dnsr[0]["ip"]."<br>";
}
if(isset($dnsr[0]["host"])){
  echo "Host: ".$dnsr[0]["host"]."<br>";
}

if(isset($dnsr[1]) && isset($dnsr[1]["target"])){
  echo "Nameserver 1: ".$dnsr[1]["target"]."<br>";
}
if(isset($dnsr[2]) && isset($dnsr[2]["target"])){
  echo "Nameserver 2: ".$dnsr[2]["target"]."<br>";
}
if(isset($headers["server"])){
  echo "Server: ".$headers["server"][0]."<br>";
}
if(isset($headers["x-powered-by"])){
  echo "Powered by: ".$headers["x-powered-by"][0]."<br>";
}
if(isset($headers["x-powered-by-plesk"])){
  echo "Plesk: ".$headers["x-powered-by-plesk"][0]."<br>";
}


?>