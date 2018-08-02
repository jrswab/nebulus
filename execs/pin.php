<?php

$pinData = shell_exec(escapeshellcmd("python steemPinCheck.py"));
$shellOut = explode("'", $pinData);
$blocks = sizeof($shellOut) - 1;
$justHash = array();

for($i = 0; $i < $blocks; $i++){
	$temp = explode(" ", $shellOut[$i]);
	array_push($justHash, $temp[1]);
}

echo var_dump($justHash)."<br /><br />";

echo shell_exec("ipfs refs local 2>&1");
