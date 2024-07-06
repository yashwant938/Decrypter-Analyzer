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
            <h1 class="pageheading">Analyzer</h1>
           <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="encryptioninpbox">
                    
                    <input type="text" required placeholder="URL..." class="inpfield weburl" name="weburl" id="weburl">
                    <button type="button" class="btn" onclick="analyze();">Analyze</button>
                </div>
            </form> 

                <div class="analyzoutput">
                
                    <div id="headeroutput" class="analyzbox">

                    </div>
                    <div id="whois" class="analyzbox">

                    </div>
                    
                    <div id="vulnerability" class="analyzbox">
                        <h2>Vulnerability</h2>
                        <div id="cors">

                        </div>
                        <div id="clickjack">

                        </div>
                    </div>
                    <div id="subdomain" class="analyzbox">

                    </div>
                    <div id="portscanner" class="analyzbox">

                    </div>
                </div>

            <div id="copied">
                Copied
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        function analyze(){
            var weburl = $("#weburl").val();
            $(".analyzbox").fadeIn();
            getHeaders(weburl);
            getWhois(weburl);
            testCORS(weburl,$("#cors"));
            getSubdomain(weburl);
            getPorts(weburl);
            getClickJack(weburl);
            
        }
        
        function getClickJack(weburl){
            $("#clickjack").html(`<div class="loading loading03"><span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span></div>`);
            $.ajax({
                url: "analyzerdetails/clickjack.php",
                type: "POST",
                data: {
                    weburl: weburl
                },
                success: function(data){
                    $("#clickjack").html(data);
                }
            });

        }
        function getPorts(weburl){
            $("#portscanner").html(`<div class="loading loading03"><span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span></div>`);
            $.ajax({
                url: "analyzerdetails/portscanner.php",
                type: "POST",
                data: {
                    weburl: weburl
                },
                success: function(data){
                    $("#portscanner").html(data);
                }
            });

        }
        function getSubdomain(weburl){
            $("#subdomain").html(`<div class="loading loading03"><span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span></div>`);
            $.ajax({
                url: "analyzerdetails/subdomain.php",
                type: "POST",
                data: {
                    weburl: weburl
                },
                success: function(data){
                    $("#subdomain").html(data);
                }
            });

        }
        function getHeaders(weburl){
            $("#headeroutput").html(`<div class="loading loading03"><span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span></div>`);
            $.ajax({
                url: "analyzerdetails/headers.php",
                type: "POST",
                data: {
                    weburl: weburl
                },
                success: function(data){
                    $("#headeroutput").html(data);
                }
            });

        }
        
        function getWhois(weburl){
            $("#whois").html(`<div class="loading loading03"><span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span></div>`);
            $.ajax({
                url: "analyzerdetails/whois.php",
                type: "POST",
                data: {
                    weburl: weburl
                },
                success: function(data){
                    $("#whois").html(data);
                }
            });

        }
        function testCORS(weburl, $elem) {
            $elem.html(`<div class="loading loading03"><span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span></div>`);

            $.ajax({
            url: weburl,
            timeout: 4000
            })
            .fail(function(jqXHR, textStatus) {
            if(jqXHR.status === 0) {
                $.ajax({
                    context: weburl,
                    type: "POST",
                    url: "analyzerdetails/cors.php",
                    data: {
                        weburl: weburl
                    }
                })
                .done(function(msg) {
                    if(msg.indexOf("HTTP") < 0) {
                        $elem.text("CORS - doesn't exist or timed out");
                    } else if(msg.indexOf("301") >= 0) {
                        $elem.text("CORS - CORS header exist");
                    } else {
                        $elem.text("CORS - CORS doesn't exist");
                    }
                });
            } else {
                $elem.text("CORS - failed ");
            }
            })
            .done(function(msg) {
                $elem.text("CORS - CORS header exist");
            }); 
        }
    </script>
</body>
</html>