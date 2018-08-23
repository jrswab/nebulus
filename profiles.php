<?php
include 'config/top.php';

$timeIs = time();

// use URI to grab username since user may not be logged in.
$fullURI = "$_SERVER[REQUEST_URI]";
$URIArray = explode('/', $fullURI);
$endURL = end($URIArray);
$rawUser = prev($URIArray);
$user = htmlspecialchars($rawUser);

// Get the full path to user profile photo
$proPho = shell_exec('ls '.$dir.'uploads/profiles/ | grep '.$user.);

// if the user profile does not exist, create.
$profile = shell_exec('ls '.$dir.'u/ | grep '.$user);
if(!$profile){
	shell_exec('mkdir '.$dir.'u/'.$user);
	shell_exec('touch '.$dir.'u/'.$user.'/index.php');
	$proPath = '"<?php require \'../../profiles.php\' ?>"';
	shell_exec("echo ".$proPath." >> u/".$user."/index.php");
}

// if the feed.php file does not exist, create.
$feed = shell_exec('ls '.$dir.'u/'.$user.' | grep feed');
if(!$feed){
	shell_exec('touch '.$dir.'u/'.$user.'/feed.php');
	$feedPath = '"<?php require \'../../feeds.php\' ?>"';
	shell_exec("echo ".$feedPath." >> u/".$user."/feed.php");
}
?>

</div><!-- this close tag relates to the memberTop.php file -->

<div class="d-flex flex-column align-items-center">
	<div id="currentPhoto" style="padding:15px;">
		<?php echo '<img src="'.$dir.'uploads/profiles/'.$proPho.'?='.$timeIs.'" 
		class="rounded img-fluid" style="max-height:150px;"/>'; ?>
	</div>

	<h1><?php echo $user; ?></h1>
	<p>
		<?php
			require 'config/config.php';
			$sqlBio = "SELECT bio FROM archivatory.users WHERE username='".$user."';";
			$runBio = mysqli_query($link, $sqlBio);
			$userData = mysqli_fetch_assoc($runBio);
			echo $userData['bio'];
		?>
		<br />
	</p>

	<div style="text-align:center;">
		<h2>Playlist 
		<a href="https://nebulus.app/u/<?php echo $user; ?>/feed.php">
			<img style="width:10%" src="<?php echo $dir; ?>img/rssLogo.png" />
		</a></h2>
	</div>

	<?php
		include 'config/uploadDBconfig.php';

		// query user data
		$sql = "SELECT * FROM ".$user." WHERE playlist=1 ORDER BY date DESC;";
		$result = mysqli_query($link, $sql);
		$resultCheck = mysqli_num_rows($result);

		if ($resultCheck > 0) {
			// loop through users' table and output into html table body	
			while ($row = mysqli_fetch_assoc($result)) { 

				// define playlist data
				$hash = $row["hash"];
				$id = $row["id"];
				// already escaped on upload
				$title = $row["title"];
				$des = $row["des"];

				// set up for content display
				$fileExt = explode('.', $id);
				$ext = strtolower(end($fileExt));
				$images = array('jpg', 'jpeg', 'png');
				$audios = array('mp3', 'wav');
				$videos = array('mp4', 'webm');

				// determine how to show the content
				if (in_array($ext, $images)){
					$display = '
					<div class="card-img-top" style="width:100%">
						<img src="'.$dir.'uploads/'.$id.'" 
						style="width:100%" />
					</div>';
				} else if (in_array($ext, $audios)){
					$display = '
					<div class="card-img-top" style="width:100%">
						<audio controls style="width:100%">
							<source src="'.$dir.'uploads/'.$id.'" type="audio/'.$ext.'">
							Your browser does not support the audio tag.
						</audio>
					</div>';
				} else if (in_array($ext, $videos)){
					$display = '
					<div class="card-img-top" style="width:100%">
						<video controls style="width:100%">
							<source src="'.$dir.'uploads/'.$id.'" type="video/'.$ext.'">
							Your browser does not support the audio tag.
						</video>
					</div>';
				}

				echo '
				<div class="card border-dark bg-light mb-3" style="min-width:100%">
					'.$display.'
					<div class="card-body text-dark">
						<h3 class="card-title">'.$title.'</h3>
						<p class="card-text">
							<h5>Description: </h5>'.$des.'
							<br /><br /><h6>IPFS Gateway: </h6><a href="https://ipfs.io/ipfs/'
							.$hash.'" target="_blank">'.$hash.'</a>
						</p>
					</div><!-- card body -->
				</div><!-- card -->';
			}
		}
	?>
</div>
<?php include 'config/bottom.html'; ?>
