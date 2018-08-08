<?php
// Initialize the session
session_start();

$dir = '';
while (!glob($dir.'hashtable.php')) {
	$dir .= '../';
}

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	include $dir.'config/mainTop.php';
} else {
	include $dir.'config/memberTop.php';
}
?>
