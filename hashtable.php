<?php include 'config/topMem.php'; ?>
			<h3>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. 
			This is your personal Archivatory Database! </h3>
		</div>

<?php
	include_once 'config/uploadDBconfig.php';
	
	//Check for deletion
	if (!empty($_GET['delete'])) {
		$sqlDelete = "DELETE FROM ".$_SESSION['username']." WHERE id='".$_GET["delete"]."'";
		$delRun = mysqli_query($link, $sqlDelete);
		$rm = shell_exec("rm uploads/".$_GET['delete']);
	}
	
	// query user data
	$sql = "SELECT * FROM ".$_SESSION['username']." ORDER BY date DESC;";
	$result = mysqli_query($link, $sql);
	$resultCheck = mysqli_num_rows($result);

	if ($resultCheck > 0) {
		// Set up the html table
		echo "		<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm'>";
		echo "<thead><tr><th scope='col'>Upload Date</th><th scope='col'>File Name
		</th><th scope='col'>IPFS Hash</th><th scope='col'>File Size</th><th scope='col'>Delete?</th>
		</tr></thead>";
		echo "<tbody>";
		// loop through users' table and output into html table body	
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<tr><td>'.$row["date"].'</td><td>'.$row["file_name"].'</td>
				<td style="word-wrap:break-word">
				<a href="https://ipfs.io/ipfs/'.$row["hash"].'" target="_blank">'
				.$row["hash"].'</a></td><td>'.$fileSize = ($row["file_size"]/1000000).' MB</td><td>
			<div class="btn-group">
					<img src="img/delete.png" width="50" type="button" class="dropdown-toggle" 
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
				<div class="dropdown-menu">
					<a class="dropdown-item" name="id" href="?delete='.$row["id"].'">Yes, delete forever.</a>
				</div>
			</div></td></tr>';
		}
		// end html table
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
	echo $_GET['delete'];
	echo $rm;
	include 'config/bottom.html';
?>
