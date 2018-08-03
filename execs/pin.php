<?php
if (!empty($_GET['pinHash'])) {
	$pinData = shell_exec(escapeshellcmd("python steemPinCheck.py"));
	$shellOut = explode("'", $pinData);
	$blocks = sizeof($shellOut) - 1;
	$justHash = array();

	for($i = 0; $i < $blocks; $i++){
		$temp = explode(" ", $shellOut[$i]);
		array_push($justHash, $temp[1]);
	}
}
	//echo var_dump($justHash)."<br /><br />";
function checkHash() {
	foreach ($justHash as $value) {
		if ($_GET['pinHash'] == $value) {
			$found = shell_exec("ipfs refs local | grep ".escapeshellcmd($value)." 2>&1");
			if(!$found){
				echo htmlspecialchars($value)." is not found on the server, now pinning. <br />";
				//echo shell_exec("ipfs pin add ".escapeshellcmd($value)." 2>&1");
			}
		}
	}
}
