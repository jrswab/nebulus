<?php
// Initialize the session
session_start();

// If session variable is not set send to login.php
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	include 'config/mainTop.php';
} else {
	include 'config/topMem.php';

	$timeIs = time();
	$proPho = shell_exec('ls uploads/profiles | grep '
		.$user);  

}
$fullURI = "$_SERVER[REQUEST_URI]";
$URIArray = explode('/', $fullURI);
$user = end($URIArray);

//shell_exec('mkdir u/'.$user);
//$userPro = 'u/'.$user.'/index.php';
?>

			<h2></h2>
		</div><!-- this close tag relates to the topM.mephp file -->

		<div class="d-flex flex-column">
			<div class="d-inline-flex flex-wrap justify-content-left align-items-center">
				<div id="currentPhoto" style="padding:15px;">
					<?php echo '<img src="uploads/profiles/'.$proPho.'?='.$timeIs.'" 
					class="rounded img-fluid" style="max-height:100px;"/>'; ?>
				</div>

				<div id="bio" class="d-inline-flex flex-column justify-content-center 
				align-items-center">
					<h3><?php echo $user; ?></h3>
					<p>Bio Here<br />
					</p>
				</div>
			</div>

			<div id="content-grid" class="row">
				<div class="col-2"></div>
				<div id="playlist" class="col">
					<h4>Playlist</h4>
					<p><?php echo $user; echo $dir; ?></p>
				</div>
			</div>
		</div>

<?php
include 'config/bottom.html';
?>
