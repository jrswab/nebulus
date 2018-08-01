<?php include 'config/top.php';

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: ".$dir."login.php");
	exit;
}

$user = htmlspecialchars($_SESSION['username']);
$proCheck = shell_exec(escapeshellcmd('ls u/ | grep '.$user));

if(!$proCheck) {
	shell_exec(escapeshellcmd('mkdir u/'.$user));
	shell_exec(escapeshellcmd('touch u/'.$user.'/index.php'));
	$proPath = '"<?php require \'../../profiles.php\' ?>"';
	shell_exec(escapeshellcmd("echo ".$proPath." >> u/".$user."/index.php"));
}
	
// if the feed.php file does not exist, create.
$feedCheck = shell_exec(escapeshellcmd('ls '.$dir.'u/'.$user.' | grep feed'));
if(!$feedCheck){
	shell_exec(escapeshellcmd('touch '.$dir.'u/'.$user.'/feed.php'));
	$feedPath = '"<?php require \'../../feeds.php\' ?>"';
	shell_exec(escapeshellcmd("echo ".$feedPath." >> u/".$user."/feed.php"));
}

if (!empty($_GET['steemName'])) {
	$steemName = htmlspecialchars($_GET['steemName']);
}

if (!empty($_GET['pinHash'])) {
	$pinHash = htmlspecialchars($_GET['pinHash']);
}
?>

			<h2>Welcome to Nebulus.</h2>
			<h4>More features are coming soon so make sure to join us on 
			<a href="https://discord.gg/dKDuaST" target="_blank">Discord</a> and 
			meet all the other Archivonauts!</h4>
		</div>
		<br>

	<div class="card border-dark mb-3">
		<div class="card-header">
			<h3>Upload Content:</h3>
		</div>
		<div class="card-body">
			<form id="upload-form" enctype="multipart/form-data" 
				action="execs/memUp.php" method="POST">
				<div class="text-center">
					<p>Max allowed file size is 250MB.</p>
					<input class="form-input" type="file" name="file" />
					<br><br>
					<div id="bar" style="display:none">
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated" 
							role="progressbar" aria-valuenow="100" aria-valuemin="0" 
							aria-valuemax="100" style="width: 100%"></div>
						</div>
						<br>
					</div>
				</div>
				<button id="click" onclick="pgShow()" 
				class="btn btn-success btn-lg btn-block" name="submit" type="submit">
				Upload</button><br>
			</form>
		</div>
	</div>

	<div class="card border-dark mb-3">
		<div class="card-header">
				<h3>Pin Content:</h3>
		</div>
		<div class="card-body">
		<form id="pin-form" action="#pinClick" method="GET">
			<div class="text-center">
				<p>Already have your content hosted on a site like Dtube and would like to 
				make sure it sticks around? Our service is the best option for you! Since 
				we are federated with nodes around the world you can be sure that at your 
				IPFS content will always have accessability even if a site deletes your 
				content.</p>
				<p>Since pinned content does not use Nebulus as it's primary storage 
				location a STEEM transaction is needed to help support the cost of the 
				server. If you want to use our service free of charge, please upload your 
				content here and then use the hash on the site of your choice.</p>
				<p>It does seem 
				that sites transcode your content for better storage utilization causing 
				the IPFS hash to be different than what you get on our website. Uploading 
				both here and a place like Dtube increases the chance that you will have 
				two different hashes and thus will not keep your content from disappearing 
				if the app loses your media.</p>
				<h4>Steem Account<br />(without "@"):</h4>
				<input style="width:40%;text-align:center" class="form-input" type="text" name="steemName" 
					placeholder="eg: jrswab" />
				<br /><br />
				<h4>Hash To Pin:</h4>
				<input style="width:80%;text-align:center" class="form-input" type="text" name="pinHash" 
					placeholder="eg: QmTFLiKypBp6RxA6L1XGDhtmMXK5DYpBnVxNcG4yp1HWVT" />
			</div>
			<br />
			<button id="pinClick"  class="btn btn-secondary btn-lg 
				btn-block" name="pinSubmit" type="submit">Grab Pin Data</button>
				<?php 
					if (!empty($_GET['steemName'] | $_GET['pinHash'])) {
						echo '<br /><br />
							<div class="text-center">
								<h5>Copy the line below and send a 1 STEEM transfer to @swab with the 
								line below as the memo:</h5>
								<p>Anyless or anymore STEEM sent will be returned without pinning. If 
								you want to support the project by donating STEEM just send with a 
								thank you memo.</p><br />
								<div class="d-inline-flex card border-dark">
									<div style="padding:10px">
										'.$steemName .' ' .$pinHash.'
									</div>
								</div>
									<h5><br />or <a href="https://v2.steemconnect.com/sign/transfer?from='
									.$steemName.'&to=swab&amount=1.000%20STEEM&memo='.$pinHash.'" target="_blank"> 
									use SteemConnect!</a></h5>
							</div>';
					} else {
						echo '';
					}
				?>
			<br />
		</form>
		</div>
	</div>

			<p class="alert alert-danger"><strong>Disclaimer:</strong> Due to the 
			nature of IPFS your content may never be able to be removed entirely from 
			the network. Even if we delete your file from our server, the hash will 
			more than likely still provide the end user with a copy. Please keep this in 
			mind when uploading and never upload anything you do not want to be online 
			forever.</p>
			<p class="alert alert-warning">
				<strong>This is still a beta service!</strong> Please do not use this as 
				a backup service. We are still in the early stages of Nebulus and 
				don't want you to lose your data. Always save a copy on an external hard drive and a separate cloud service for redundancy.</p>
		
		<h3>How To Use:</h3>
		<div>
			<ol>
				<li>Click "Select File"</li>
				<li>Click "Upload"</li>
				<li>Wait. The larger the file, the longer it will take to upload so be patient.</li>
			</ol>
		</div>
		
		<p>For video content, we recommend 
			<a href="https://handbrake.fr" target="_blank">HandBreak</a>. It's a free 
			and open-source video transcoder that lets the user input their original 
			video and output a web-optimized version. This optimized version will not 
			only upload faster with our service, but will also have better playback for 
			your viewers.</p>
		
		<p>Severs of this size are quite expensive; please consider donating STEEM 
			or SBD to <a href="https://steemit.com/@jrswab">@jrswab</a> in order to 
			keep this service running. Be sure to add a memo to let us know the 
			donation is for this project and we'll add your name to the coming 
			"supporters" page.</p>
		
		<p>Donations help show that you would like to see further development on 
			this project. Some things we'd like to include:  user signups so you can 
			save your hashes for future reference, better user experience, and 
			SteemConnect integration.</p>

		<p>If you have a Steem account and find this service helpful please 
			<a href="https://steemconnect.com/sign/account-witness-vote?witness=jrswab&approve=1" target="_blank">
				vote for @jrswab's witness server</a>. Every vote counts, no matter how much 
			Steem Power you hold.</p>

		<p>Join us on <a href="https://discord.gg/dKDuaST" target="_blank">
			Discord</a>!</p>
<script>
	function pgShow() {
		var bar = document.getElementById("bar");
		bar.style.display = "block";
	}

	function pinShow() {
		var bar = document.getElementById("pinText");
		bar.style.display = "block";
	}
</script>
<?php include 'config/bottom.html'; ?>
