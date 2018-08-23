<?php include '../config/top.php';

if (isset($_POST['submit'])) {
	$file = $_FILES['file']; // define file

	$fileName = $_FILES['file']['name']; // grab the file name
	$fileTmpName = $_FILES['file']['tmp_name']; // define file temp name
	$fileSize = $_FILES['file']['size']; // grab the file size
	$fileError = $_FILES['file']['error']; // define error code
	$fileType = $_FILES['file']['type']; // grab the file type

	// separate the file extension from the file name
	$fileExt = explode('.', $fileName);
	// convert the extension to lower case
	$fileActualExt = strtolower(end($fileExt));

	// allowed file extensions
	$allowed = array('jpg');

	// check if file extension is allowed first
	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) { // check for no error codes
			if ($fileSize < 2202010) { // make sure file size is less than 2MB
				// give the upload a unique name
				echo $_SESSION['username'];
				$fileNameNew = $_SESSION['username'].".".$fileActualExt;
				// define file upload end location
				$fileDestination = '../uploads/profiles/'.$fileNameNew;
				// move the file
				move_uploaded_file($fileTmpName, $fileDestination);
				// return user to settings.php
				header('Location: ../settings.php');
			} else {
				echo "Your file is too big. For best results please keep your file under 250MB.";
			}
		} else {
			echo "There was an error during uploading. Please try again.";
		}
	} else {
		echo "Sorry, the ".$fileActualExt." file type is not supported.<br />Please use .jpg, thank you.";
	}
}

include '../config/bottom.html';
