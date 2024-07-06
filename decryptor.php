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
            <h1 class="pageheading">Decryptor</h1>
           <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="encryptioninpbox">
                    <select name="dynctype" class="inpfield dynctype" id="dynctype" required>
                        <option value="">- Type -</option>
                        <option value="md5">MD5</option>
                        <option value="sha1">SHA1</option>
                        <option value="sha256">SHA256</option>
                        <option value="sha512">SHA512</option>
                        <option value="snefru256">Snefru256</option>
                    </select>
                    <select name="dyncattacktype" class="inpfield dyncattacktype" id="dyncattacktype" required onChange="cheackatt();">
                        <option value="">- Attack -</option>
                        <option value="rainbowtable">Rainbow Table</option>
                        <option value="disatt">Disnory attack</option>
                        <option value="numatt">Number attack</option>
                        <option value="cpatt">Common Password attack</option>
                    </select>
                    <select name="dyncnumrange" class="inpfield numrange" id="dyncnumrange">
                        <option value="">- Attack -</option>
                        <option value="1000000" selected>0 - 1000000</option>
                        <option value="2000000">1000000 - 2000000</option>
                        <option value="3000000">2000000 - 3000000</option>
                        <option value="4000000">3000000 - 4000000</option>
                        <option value="5000000">4000000 - 5000000</option>
                        <option value="6000000">5000000 - 6000000</option>
                        <option value="7000000">6000000 - 7000000</option>
                        <option value="8000000">7000000 - 8000000</option>
                        <option value="9000000">8000000 - 9000000</option>
                        <option value="10000000">9000000 - 10000000</option>
                        <option value="100000000">10000000 - 100000000</option>
                    </select>
                    

                    <input type="text" required placeholder="Plain text..." class="inpfield eynctext" name="eynctext" id="eynctext">
                    <button type="button" onclick="cracktext()" class="btn">Decrypt</button>
                </div>
            </form> 
            
                <div class="encyoutput">
                    
                </div>

       
            <div id="copied">
                Copied
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        function cracktext(){
            $(".encyoutput").html(`<div class="loading loading03"><span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span></div>`);
            
            var dynctype = $("#dynctype").val();
            var eynctext = $("#eynctext").val();
            var dyncattacktype = $("#dyncattacktype").val();
            var dyncnumrange = $("#dyncnumrange").val();
            
            //Ajax call to crack text
            $.ajax({
                url: "cracktext.php",
                type: "POST",
                data: {
                    dynctype: dynctype,
                    eynctext: eynctext,
                    dyncattacktype: dyncattacktype,
                    dyncnumrange: dyncnumrange
                },
                success: function(data){
                    $(".encyoutput").html(data);
                }
            });

        }
    </script>
</body>
</html>