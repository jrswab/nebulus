<?php

if (!empty($_GET['pinHash'])) {
	$pinHash = htmlspecialchars($_GET['pinHash']);
	$pinDataCmd = escapeshellcmd("python steemPinCheck.py ".$pinHash);
	$pinData = shell_exec($pinDataCmd);
	$server = $_SERVER['HTTP_HOST'];

	$pinCheck = shell_exec("ipfs pin ls | grep ".$pinHash." 2>&1");

	if ($pinCheck) {
		header("Location: ../welcome.php");
	} else {
		$run = shell_exec("ipfs pin add ".$pinHash." > /dev/null 2>&1 &");
		header("Location: ../welcome.php");
	}
} else {
		header("Location: ../welcome.php");
}
