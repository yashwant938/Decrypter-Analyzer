<?php
ini_set('memory_limit', '900M');
ini_set('max_execution_time', 0);
require_once "includes/conn.php";

$insert=0;
$count=0;
$fileread = file('passlist/rainbow/tuscl.txt',FILE_IGNORE_NEW_LINES);
$sql = "INSERT INTO rainbow_table (plain_text, md5, sha1, sha256, sha512, snefru256) VALUES ";
$param="";
foreach($fileread as $word){
    $count++;
    $enword=geteync($word);
    $word=addslashes($word);
    $param= " ('".$word."', '".$enword["md5"]."', '".$enword["sha1"]."', '".$enword["sha256"]."', '".$enword["sha512"]."', '".$enword["snefru256"]."')";
    try{
        $finalsql=$sql.$param;   
        if($conn->exec($finalsql)){
            $insert++;
        }
        
    }catch(PDOException $e){
        continue;
    }
}

function geteync($plaintext){
    $enyctext=array();
    $enyctext["md5"] = md5($plaintext);
    $enyctext["sha1"] = sha1($plaintext);
    $enyctext["sha256"] = hash('sha256',$plaintext);
    $enyctext["sha512"] = hash('sha512',$plaintext);
    $enyctext["snefru256"] = hash('snefru256',$plaintext);
    return $enyctext;
}

?> 