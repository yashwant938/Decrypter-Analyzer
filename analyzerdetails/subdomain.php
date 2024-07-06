<?php
error_reporting(0);
$nomer = 1;
$input = $_POST['weburl'];
$url = parse_url($input, PHP_URL_HOST);

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://sonar.omnisint.io/subdomains/".$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch); 
curl_close($ch); 

$json = json_decode($output, true);
?>

<h2>Subdomain</h2>
    <table class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>List Subdomain</th>
        <tr>
        <?php
            for($i=0; $i < count($json); $i++) {
                $target = "_blank";
                echo "<tr>";
                echo "<td>".$nomer++."</td>";
                echo "<td><a target='".$target."' class='linkcolor' href='http://".$json[$i]."'>".$json[$i]."</a></td>";
                echo "</tr>";
            }
        ?>
    </table>