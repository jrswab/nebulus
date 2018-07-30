<?php 
include 'config/memberTop.php'; 
include_once 'config/uploadDBconfig.php';

$user = htmlspecialchars($_SESSION['username']);

// add playlist column if non-existant.
if($playlistCheck = $link->query("SELECT playlist FROM '".$user."'")) {
	echo '';
} else {
	$addPlaylist = "ALTER TABLE ".$_SESSION['username']." ADD playlist TINYINT(1);";
	$link->query($addPlaylist);
}

//Check for deletion
if (!empty($_GET['delete'])) {
	$sqlDelete = "DELETE FROM ".$user." WHERE id='".$_GET["delete"]."'";
	$delRun = mysqli_query($link, $sqlDelete);
	$rm = shell_exec(escapeshellcmd("rm uploads/".$_GET['delete']));
}

// Check for add to playlist
if (!empty($_GET['addPlay'])) {
	$sqlAddPlay = "UPDATE ".$user." SET playlist = 1, date = date  WHERE id='".$_GET['addPlay']."'";
	$runAddPlay = mysqli_query($link, $sqlAddPlay);
} 

// Check for removal from playlist
if (!empty($_GET['delPlay'])) {
	$sqlDelPlay = "UPDATE ".$user." SET playlist = 0, date = date WHERE id='".$_GET['delPlay']."'";
	$runDelPlay = mysqli_query($link, $sqlDelPlay);
}

// query user data
$sql = "SELECT * FROM ".$user." ORDER BY date DESC;";
$result = mysqli_query($link, $sql);
$resultCheck = mysqli_num_rows($result);
?>
<h3>Your personal Archivatory Database! </h3>
</div>
<div class="d-flex flex-column align-items-center">
	<?php
		if ($resultCheck > 0) {
			// loop through users' table and output into html table body	
			while ($row = mysqli_fetch_assoc($result)) {
				$playlist = $row["playlist"];
				$fileName = $row["file_name"];
				$hash = $row["hash"];
				$fileSize = round(($row["file_size"]/1000000), 2);
				$id = $row["id"];
				// already escaped on upload to server
				$title = $row["title"];
				$des = $row["des"];

				// if user playlist column for the content is '0'
				// show the add button else show the remove button.
				if ($playlist == 0) {
					$onList = '
						<div class="btn-group">
								<button type="button" class="btn btn-success dropdown-toggle" 
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Add to</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" name="addPlay" href="?addPlay='.$id.'">Yes, add to playlist.</a>
							</div>
						</div>';
				} else {
					$onList = '
						<div class="btn-group">
								<button type="button" class="btn btn-warning dropdown-toggle" 
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Remove</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" name="delPlay" href="?delPlay='.$id.'">Yes, remove from playlist.</a>
							</div>
						</div>';
				}	
				// set up for content display
				$fileExt = explode('.', $id);
				$ext = strtolower(end($fileExt));
				$images = array('jpg', 'jpeg', 'png');
				$audios = array('mp3');
				$videos = array('mp4', 'm4v', 'webm');
				
				// determine how to show the content
				if (in_array($ext, $images)){
					$display = '
					<div style="width:100%">
						<img src="uploads/'.$id.'" style="width:100%" />
					</div>';
				} else if (in_array($ext, $audios)){
					$display = '
					<div style="width:100%">
						<audio controls style="width:100%">
							<source src="uploads/'.$id.'" type="audio/'.$ext.'">
							Your browser does not support the audio tag.
						</audio>
					</div>';
				} else if (in_array($ext, $videos)){
					$display = '
					<div style="width:100%">
						<video style="width:100%" controls>
							<source src="uploads/'.$id.'" type="video/'.$ext.'">
							Your browser does not support the video tag.
						</video>
					</div>';
				} else {
					$display = 'The '.$ext.' media format is not currently supported';
				}

				// echo out content cards for users to see the uploaded file, add a title,
				// add a description, grad the link, add to their playlist,
				// and delete the content from the server.
				echo '
				<div class="card border-dark mb-3" style="min-width:99%" >
					<div class="card-header bg-secondary text-light"><h4>'.$fileName.'</h4></div>
					<div class="card-body text-dark">
						<div class="d-flex justify-content-center">'.$display.'</div>
						<br />
						<form enctype="multipart/form-data" action="execs/rssMeta.php" method="POST">
							<span style="font-weight: bold">Title:</span>
							<input name="title" type="text" class="form-control" placeholder="'.$title.'"><br />
							<span style="font-weight: bold">Description:</span>
							<textarea name="des" class="form-control" rows="3" placeholder="'.$des.'"></textarea><br />
							<input type="hidden" name="rowID" value="'.$id.'">
							<button type="submit" class="btn btn-primary">Submit</button>
						</form><br />

						<p class="card-text">
							<strong>File Type: </strong>'.$ext.'<br />
							<strong>IPFS Link: </strong>
							<a href="https://ipfs.io/ipfs/'.$hash.'" target="_blank">'.$hash.'</a><br />
							<strong>Size: </strong>'.$fileSize.' MB
						</p>
						<p class="card-text"></p>

						<div class="row">
							<div class="col d-flex justify-content-start">
								<span style="font-weight: bold">Playlist:</span>
							</div>
							<div class="col d-flex justify-content-end">
								<span style="font-weight: bold"></span>
							</div>
						</div>

						<div class="row">
							<div class="col d-flex justify-content-start">'.$onList.'</div>

							<div class="col d-flex justify-content-end">
								<div class="btn-group">
										<button type="button" class="btn btn-danger dropdown-toggle" 
										data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Delete</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" name="id" href="?delete='.$id.'">Yes, delete forever.</a>
									</div>
								</div><!-- delete button group -->
							</div><!-- column for button group -->
						</div><!-- class row -->
					</div><!-- card body -->
				</div><!-- card -->';
			}
		}
	?>
</div>

<?php	include 'config/bottom.html'; ?>
