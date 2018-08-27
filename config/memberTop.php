<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: ".$dir."login.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nebulus</title>
	<link rel="stylesheet" 
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" 
	integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" 
	crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Archivonaut Favicons -->
	<link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicons/favicon-16x16.png">
	<link rel="manifest" href="img/favicons/site.webmanifest">
	<link rel="mask-icon" href="img/favicons/safari-pinned-tab.svg" color="#f51e0f">
	<link rel="shortcut icon" href="img/favicons/favicon.ico">
	<meta name="msapplication-TileColor" content="#f51e0f">
	<meta name="msapplication-config" content="img/favicons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<!-- end favicons -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">                                               
<a class="navbar-brand" href="<?php echo $dir; ?>welcome.php">

	<?php echo '<img src="'.$dir.'img/favicons/android-chrome-512x512.png" width="30" height="30"                                        
	class="d-line-block align-top" alt="Nebulus-Archie">' ?>
	Nebulus
</a>                                                                                                    
<button class="navbar-toggler" type="button" data-toggle="collapse"                                     
	data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"                              
	aria-label="Toggle navigation">                                                                       
	<span class="navbar-toggler-icon"></span>                                                             
</button>                                                                                               
<div class="collapse navbar-collapse" id="navbarNav">                                                   
	<ul class="navbar-nav"> 
			<li class="nav-item">
			<a class="nav-link" href="<?php echo $dir; ?>welcome.php">Upload</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo $dir; ?>hashtable.php">Media</a>
		</li>
		<!--<li>
			<a class="nav-link" href="<?php echo $dir; ?>u/
			<?php //echo htmlspecialchars($_SESSION['username']); ?>">Profile</a>
		</li>-->
		<li class="nav-item">
		<a class="nav-link" href="<?php echo $dir; ?>settings.php">
			Settings</a>
		</li>
		<li class="nav-item">
		<a class="nav-link text-danger" href="<?php echo $dir; ?>logout.php">
			<strong>Logout</strong></a>
		</li>
	</ul>
</div>
</nav>

	<div id="content" class="container">
		<div style="text-align:center;">
			<br>
