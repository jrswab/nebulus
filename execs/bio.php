<?php 
include '../config/top.php';
include '../config/config.php';

if (isset($_POST['bioSubmit'])) {
	$bio = htmlspecialchars($_POST['bioInfo']);
	$user = htmlspecialchars($_SESSION['username']);

	$sqlBioUpload = "UPDATE users SET bio='".$bio."' WHERE username='".
		$user."';";
	$runBioUpload = mysqli_query($link, $sqlBioUpload);

	if ($runBioUpload) {
		header("Location: ../u/".$user);
	} else {
		echo "Could not upload user bio. <br />";
		echo $link->error;
		echo '<br /><br /> Please take a screen shot and send it to the 
		#support thread on our <a href="https://discord.gg/PVNKWDx"> 
		Discord chat</a>';
	}
}
include '../config/bottom.html';
