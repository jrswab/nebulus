<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login.php");
  exit;
}

// escape user info into variables.
$user = htmlspecialchars($_SESSION['username']);
$title = htmlspecialchars($_POST['title']);
$des = htmlspecialchars($_POST['des']);

// Logging info for database containing user tables.
include_once '../config/uploadDBconfig.php';

// Check if a table call 'username' exists
if ($tableCheck = $link->query("SHOW TABLES LIKE '".$user."'")) {
	if($tableCheck->num_rows == 1) {
		// Check if the 'title' column exists
		if($titleTest = $link->query("SELECT title FROM '".$user."'")) {
				echo '';
		} else {
			// if the title  column does not exist add it and a 'des' column
			$addTitle = "ALTER TABLE ".$user." ADD title VARCHAR(256);";
			$link->query($addTitle);
			$addDes = "ALTER TABLE ".$user." ADD des VARCHAR(60000);";
			$link->query($addDes);
		}
	}
}

// if the title field was not left blank
if (!$_POST['title']) {
	echo '';
} else {
	// if the title field was filled in add it to the database.
	$changeTitle = "UPDATE ".$user." SET title = '".$title."', date = date WHERE id = '".$_POST['rowID']."';";
	$link->query($changeTitle);
}

// if the description field was not left blank
if (!$_POST['des']) {
	echo '';
} else {
	// if the descriptyon field was filled in add it to the database.
	$changeDes = "UPDATE ".$user." SET des = '".$des."', date = date WHERE id = '".$_POST['rowID']."';";
	$link->query($changeDes);
}

$link->close();

// send user back to hashtable.php
header("location: ../hashtable.php");
