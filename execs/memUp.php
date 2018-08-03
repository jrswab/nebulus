<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login.php");
  exit;
}

// Finding where the root directory is for Archivatory.com
$dir = "";
while (!glob($dir.'execs/')) {
	$dir .= '../';
}

// Loging info for database contianing user tables.
include_once '../config/uploadDBconfig.php';

// Check if a table call 'username' exists
if ($tableCheck = $link->query("SHOW TABLES LIKE '".htmlspecialchars($_SESSION['username'])."'")) {
	if($tableCheck->num_rows < 1) {
		$sql = "CREATE TABLE ".$_SESSION['username']." (
		date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		file_name VARCHAR(256) NOT NULL,
		hash VARCHAR(256) NOT NULL,
		file_size VARCHAR(256) NOT NULL,
		id VARCHAR(256) NOT NULL,
		playlist TINYINT(1) NOT NULL
		title VARCHAR(256)
		desc TEXT)";

		$link->query($sql);
	} else if($playlistCheck = $link->query("SELECT playlist FROM '".
		htmlspecialchars($_SESSION['username'])."'")) {
			echo "";
		} else {
			$addPlaylist = "ALTER TABLE ".$_SESSION['username']." ADD playlist TINYINT(1);";
			$link->query($addPlaylist);
		}
  	echo " ";
}

if (isset($_POST['submit'])) {
	$file = $_FILES['file']; // define file

	$fileName = $_FILES['file']['name']; // grab the file name
	$fileTmpName = $_FILES['file']['tmp_name']; // define file temp name
	$fileSize = $_FILES['file']['size']; // grab the file size
	$fileError = $_FILES['file']['error']; // define error code
	$fileType = $_FILES['file']['type']; // grab the file type

	$fileExt = explode('.', $fileName); // separate the file extension from the file name
	$fileActualExt = strtolower(end($fileExt)); // convert file extension to lowercase

	// allowed file extensions
	$allowed = array('jpg', 'jpeg', 'png', 'mp4', 'm4v', 'ogg', 'mp3', 'webm');

	if (in_array($fileActualExt, $allowed)) { // check if file extension is allowed
		if ($fileError === 0) { // check for no error codes
			if ($fileSize < 251000000) { // make sure file size is less than 251MB
				$fileNameNew = uniqid('', true).".".$fileActualExt; // give the upload a uniqe name
				$fileDestination = '../uploads/'.$fileNameNew; // define file upload end location
				move_uploaded_file($fileTmpName, $fileDestination); // move the file
				// Appache runs IPFS upload command
				$output = shell_exec("ipfs add ".$fileDestination." 2>&1");
				$dicedOut = explode(' ', $output); // create an array of the IPFS STDOUT dilimited on spaces
				end($dicedOut); // Move pointer to the end of the array
				$hash = prev($dicedOut); // display the second to last item in the array

				// add info to users' table
				$sqlAdd = "INSERT INTO ".$_SESSION['username'].
					" (date, file_name, hash, file_size, id, playlist) 
					VALUES ('".date("Y/m/d H:i:s")."', '".$fileName."', '".$hash."', '"
					.$fileSize."', '".$fileNameNew."', 0);";
				// run INSERT command
				$runSql = mysqli_query($link, $sqlAdd);

				// if INSERT is successful send user to their hash table else echo error
				if ($runSql === true) {
					header("Location: ../hashtable.php");
				} else {
					echo "Error: " . $sqlAdd . "<br />" . $link->error;
					echo "<br><br>Please copy this page or take a screen shot and send it to 
						the #support thread on our <a href='https://discord.gg/PVNKWDx'>
						Discord chat</a>";
				}
			} else {
				echo "Your file is too big. For best results please keep your file under 500MB.";
				echo "<br><br><a href='".$dir."welcome.php'>Return to upload</a>";
			}
		} else {
			echo "There was an error during uploading. Please try again.";
			echo "<br><br><a href='".$dir."welcome.php'>Return to upload.</a>";
		}
	} else {
		echo "Sorry, the ".$fileActualExt." file type is not supported.";
		echo "<br><br><a href='".$dir."welcome.php'>Return to upload.</a>";
	}
}

$link->close();
