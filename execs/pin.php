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
foreach ($justHash as $value) {
	$found = shell_exec("ipfs refs local | grep ".$value." 2>&1");
	if($found){
		echo $found."<br />";
	} else {
		echo $value." not found on the server <br />";
	}
}
//echo shell_exec("ipfs pin add Qmbz2b8nf8YRgkuzX4grTpDfeFXVJQzDTcteu3Dj616Du5");
