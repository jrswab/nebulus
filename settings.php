<?php include 'config/top.php'; ?>
			<h2>Settings</h2>
		</div><!-- this close tag relates to the topM.mephp file -->
		<div class="d-flex flex-column justify-content-center">
			<div class="d-inline-flex flex-wrap justify-content-center align-items-center">
				<div id="currentPhoto" style="padding:15px;">
					<?php
					$timeIs = time();
					$proPho = shell_exec('ls uploads/profiles | grep '
					.htmlspecialchars($_SESSION['username']));  

					if (!$proPho) {
						echo '<img src="img/archieTheArchivonaut.png" 
						class="rounded img-fluid" style="max-height:250px;"/>';

					} else {
						echo '<img src="uploads/profiles/'.$proPho.'?='.$timeIs.'" 
						class="rounded img-fluid" style="max-height:250px;"/>';
					}
					?>
				</div>
<!-- Upload and display user profile image -->
				<div id="uploadPro" class="d-inline-flex flex-column justify-content-center">
					<h5>Upload Profile Image:</h5>
					<p>Max allowed file size is 2MB</p>
					<form id="profilePhoto" class="form-group" enctype="multipart/form-data" action="execs/proPhoUp.php" method="POST">
						<input class="form-input" type="file" name="file" />
						<br /><br />
						<button id="proPhoClick" onclick="pgShow()" class="btn btn-success" name="submit" type="submit">Upload Photo</button>
						<br /><br />

						<div id="bar" style="display:none;">
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
								</div>
								<br>
						</div>

					</form>
				</div>

			</div>
			<br />
<!-- User profile bio -->
			<div id="bio" class="d-inline-flex flex-column">
				<h5>Bio:</h5>
				<form id="bio-form" class="form-group" enctype="multipart/form-data" action="execs/bio.php" method="POST">
					<textarea class="form-control" id="bio-info" rows="4" maxlength="250" name="bioInfo"></textarea>
					<br />
					<button id="bioSubmit" class="btn btn-success" name="bioSubmit" type="submit">Submit Bio</button>
				</form>
			</div>
			<br /><br />
<!-- User accound deletion -->
			<div class="d-inline-flex justify-content-center">
			<button id="delButton" class="btn btn-danger" style="width:50%;font-weight:bold;" onclick="pop()">Delete Account</button>
			<br /><br />

			<div id="delAlert" class="alert alert-danger alert-dismissible fade show" 
				style="display:none;" role="alert">

				<form id="delForm" class="d-flex flex-wrap justify-content-center" 
					action="execs/delUser.php" method="POST">
					<p style="font-size:1em; text-align:center;">
						You are about to delete your account.<br />
						<strong>This process is permanent!</strong><br />
						Click here only if you understand and would like to continue.&nbsp;&nbsp;
					</p>
					<input name="user" type="text" style="display:none" 
						value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
					</input>
					<button type="submit" name="delAccount" class="btn btn-danger btn-lg">
						Yes, delete my account.
					</button>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</form>
				</div>
			</div>
		</div>
<script>
	function pop(){
		document.getElementById("delButton").style = "display: none";
		document.getElementById("delAlert").style = "display: block";
	}

	function pgShow() {
		var bar = document.getElementById("bar");
		bar.style.display = "block";
	}

</script>
<?php include 'config/bottom.html'; ?>
