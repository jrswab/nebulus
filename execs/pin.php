<?php

if (!empty($_GET['pinHash'])) {
	$pinHash = $_GET['pinHash'];
	$hashArg = escapeshellarg($pinHash);
	$pinDataCmd = "python steemPinCheck.py ".$hashArg;
	$pinData = shell_exec($pinDataCmd);
	$ready = rtrim($pinData);
	echo $pinHash. " <br />";
	echo var_dump($ready)." <br />";

	if ($ready == "ready") {
		$checkList = shell_exec("ipfs pin ls | grep ".$hashArg." 2>&1");
		$checkExp = explode(' ', $checkList);
		$pinCheck = $checkExp[0];

		if ($pinCheck == $pinHash) {
			header("Location: ../welcome.php");
		} else {
			echo shell_exec("ipfs pin add $hashArg > /dev/null 2>&1 &");
			header("Location: ../welcome.php");
		}
	} else {
		header("Location: ../welcome.php");
	}
	
} else {
		header("Location: ../welcome.php");
}
