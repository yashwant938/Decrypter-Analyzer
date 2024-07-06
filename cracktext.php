<?php

require_once "includes/functions.php";

ini_set('memory_limit', '256M');
ini_set('max_execution_time', 0);
$dynctype=trim($_POST['dynctype']);
$eynctext=trim($_POST['eynctext']);
$dyncattacktype=$_POST['dyncattacktype'];

$isFound=false;
$foundWord="";
if($dyncattacktype=="rainbowtable"){
    require_once "includes/conn.php";

    $sql = "SELECT plain_text FROM rainbow_table WHERE $dynctype = :plain_text LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':plain_text', $eynctext);
    $stmt->execute();
    $result = $stmt->fetch();
    if($result){
        $isFound=true;
        $foundWord=$result["plain_text"];
    }
}elseif($dyncattacktype=="disatt"){
    $fileread = file('passlist/big_pass_list.txt',FILE_IGNORE_NEW_LINES);
    foreach($fileread as $word){
        $enword=geteync($word,$dynctype);
        if($eynctext==$enword){
            $isFound=true;
            $foundWord=$word;
            break;
        }
    }
}elseif($dyncattacktype=="numatt"){
    $range=$_POST["dyncnumrange"];
    $j=0;
    $k=0;
    $sn=0;
    $sn=9000000;
    $i=$range-1000000;
    $k=10000000;
    if($range=="100000000"){
        $sn=10000000;
        $i=10000000;
        $k=100000000;
    }
    for($i;$i<=$k;$i++){
        $eyncnum=geteync($i,$dynctype);
        //	echo "Trying text = ".$i."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$j."<br>";
        if($eyncnum==$eynctext){
            $isFound=true;
            $foundWord=$i;
            break;
        }
    }
}elseif($dyncattacktype=="cpatt"){
    $fileread = file('passlist/common_pass.txt',FILE_IGNORE_NEW_LINES);
    foreach($fileread as $word){
        $enword=geteync($word,$dynctype);
        if($eynctext==$enword){
            $isFound=true;
            $foundWord=$word;
            break;
        }
    }
}

if($isFound){ ?>
<div class="encryptioninpbox">
    <input type="text" class="inpfield" id="dynccouttext" value="<?php echo $foundWord; ?>" readonly>
    <button type="submit" class="btn" onclick="copyToClipboard(document.getElementById('dynccouttext'))">Copy</button>
</div>
<?php
}else{
    if($dyncattacktype=="numatt"){
        echo "<div class='encryptioninpbox'>Number Deosn't Exist Between ".$sn." - ".$k.", Try Different Range</div>";
    }else{
        echo "<div class='encryptioninpbox'>Text Deosn't Found, Try Different attack</div>";
    }
}





?>