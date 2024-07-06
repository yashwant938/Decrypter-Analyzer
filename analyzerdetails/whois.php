<?php
require "../vendor/autoload.php";
require_once "../includes/functions.php";

$weburl = $_POST["weburl"];

use Iodev\Whois\Factory;
use Iodev\Whois\Exceptions\ConnectionException;
use Iodev\Whois\Exceptions\ServerMismatchException;
use Iodev\Whois\Exceptions\WhoisException;

echo "<h2>WhoIs</h2>";
try {
    $whois = Factory::get()->createWhois();
    $info = $whois->loadDomainInfo(get_domain($weburl));
    if (!$info) {
        print "Null if domain available";
        exit;
    }
    echo "Owner: ".$info->owner."<br>";
    echo "Registrar: ".$info->registrar."<br>";
    echo "Creation Date: ".date("d/m/Y H:i:s", $info->creationDate)."<br>";
    echo "Updated Date: ".date("d/m/Y H:i:s", $info->updatedDate)."<br>";
    echo "Expiration Date: ".date("d/m/Y H:i:s", $info->expirationDate)."<br>";
    echo "States: ".$info->states[0]."<br>";
    
} catch (ConnectionException $e) {
    print "Disconnect or connection timeout";
} catch (ServerMismatchException $e) {
    print "TLD server (.com for google.com) not found in current server hosts";
} catch (WhoisException $e) {
    print "Whois server responded with error '{$e->getMessage()}'";
}

?>