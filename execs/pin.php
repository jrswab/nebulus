<?php

if (!empty($_GET['pinHash'])) {
	$pinHash = $_GET['pinHash'];
	$hashArg = escapeshellarg($pinHash);
	$pinDataCmd = "python steemPinCheck.py ".$hashArg;
	$pinData = shell_exec($pinDataCmd);
	$ready = rtrim($pinData);
/*
	echo $pinHash;
	echo "<br />";
	echo $hashArg;
	echo "<br />";
	echo $pinDataCmd;
	echo "<br />";
	echo $pinData;
	echo "<br />";
	echo $ready;
	echo "<br />";
 */
	if ($ready == "ready") {
		$checkList = shell_exec("ipfs pin ls | grep ".$hashArg." 2>&1");
		$checkExp = explode(' ', $checkList);
		$pinCheck = $checkExp[0];

		if ($pinCheck == $pinHash) {
			//echo "found";
			header("Location: ../welcome.php");
		} else {
			$pinExe = "python pyPin.py $hashArg";
			/*
			echo $pinExe;
			echo "<br />";
			echo "running";
			echo "<br />";
			 */
			exec($pinExe);
			header("Location: ../welcome.php");
		}
	} else {
		//echo "not ready";
		header("Location: ../welcome.php");
	}
	
} else {
		header("Location: ../welcome.php");
}
