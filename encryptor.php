<?php
$executiontime = "";
$enyctext="";
$enyctype="";
$plaintext="";
if(isset($_POST["plaintext"])){
    $enyctype = $_POST["enyctype"];
    $plaintext = $_POST["plaintext"];
    $t = microtime(true);

    $isExecuted=false;
    if($enyctype=="md5"){
        $enyctext = md5($plaintext);
        $isExecuted=true;
    }elseif($enyctype=="sha1"){
        $enyctext = sha1($plaintext);
        $isExecuted=true;
    }elseif($enyctype=="sha256"){
        $enyctext = hash('sha256',$plaintext);
        $isExecuted=true;
    }elseif($enyctype=="sha512"){
        $enyctext = hash('sha512',$plaintext);
        $isExecuted=true;
    }elseif($enyctype=="bcrypt"){
        $enyctext = password_hash($plaintext, PASSWORD_BCRYPT);
        $isExecuted=true;
    }elseif($enyctype=="snefru256"){
        $enyctext = hash('snefru256',$plaintext);
        $isExecuted=true;
    }

    if($isExecuted){
        $diff=round(((microtime(true)-$t) * 1000),4);
        $executiontime="Execition time {$diff} milliseconds";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="window">
        <header>
            <div class="menu">
              <ul><li><a href="index.php">Home</a></li><li><a href="encryptor.php">/Encryptor</a></li><li><a href="decryptor.php">/Decryptor</a></li><li><a href="analyzer.php">/Analyzer</a></li></ul>
            </div>
          </header>
        <div class="container">
            <h1 class="pageheading">Encryptor</h1>
           <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="encryptioninpbox">
                    <select name="enyctype" class="inpfield enyctype" required>
                        <option value="">- Type -</option>
                        <option value="md5"<?php if($enyctype=="md5"){ echo " selected"; } ?>>MD5</option>
                        <option value="sha1"<?php if($enyctype=="sha1"){ echo " selected"; } ?>>SHA1</option>
                        <option value="sha256"<?php if($enyctype=="sha256"){ echo " selected"; } ?>>SHA256</option>
                        <option value="sha512"<?php if($enyctype=="sha512"){ echo " selected"; } ?>>SHA512</option>
                        <option value="bcrypt"<?php if($enyctype=="bcrypt"){ echo " selected"; } ?>>Bcrypt</option>
                        <option value="snefru256"<?php if($enyctype=="snefru256"){ echo " selected"; } ?>>Snefru256</option>
                    </select>
                    <input type="text" required placeholder="Plain text..." class="inpfield plaintext" name="plaintext" value="<?php echo $plaintext; ?>">
                    <button type="submit" class="btn">Encypt</button>
                </div>
            </form> 
            <?php if($enyctext){ ?>
                <div class="encyoutput">
                    <div class="executiontime">
                        <?php echo $executiontime; ?>
                    </div>
                    <div class="encryptioninpbox">
                        <input type="text" class="inpfield" id="enycouttext" value="<?php echo $enyctext; ?>" readonly>
                        <button type="submit" class="btn" onclick="copyToClipboard(document.getElementById('enycouttext'))">Copy</button>
                    </div>
                </div>

            <?php } ?>
            <div id="copied">
                Copied
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>