<?php
require_once "../includes/functions.php";
ini_set('max_execution_time', 0);
ini_set('memory_limit', -1);

$weburl=$_POST["weburl"];
$host = get_domain($weburl);
$ports = array("21","22","23","25","53","80","81","110","115","135","139","143","194","443","445","587","1433","2525","3306","3389","5632","5900","6112");

echo "<h2>Port Scanning</h2>";
foreach ($ports as $port)
{
    $connection = @fsockopen($host, $port, $errno, $errstr, 2);

    if (is_resource($connection))
    {
        echo '<p>'. $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</p>' . "\n";

        fclose($connection);
    }
}