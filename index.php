<?php include 'config/top.php'; ?> 
	<h2>Welcome to Nebulus.</h2>
	<p>Nebulus is a PHP project that gives the content creator a place to host 
		their content for the Interplanetary File System (IPFS) network. The more 
		places their content exists, the better the chance that the work will be 
		available via an IPFS gateway whenever the viewer wishes to consume the 
		media. The idea for this service spun out of the developer's own desire for a 
		list of all the files he uploaded to IPFS from his home server.
		<br /><br />
		After chatting with a few Steemians (cryptocurrency earing content creators), 
		it was clear that the developer was not the only one looking for a more 
		natural way to use IPFS. We are still a very new project with lots of 
		milestones we what to reach to provide as much value for "Nebunauts" all 
		around the galaxy. A long-term milestone for Nebulus is to turn it into 
		a federated service because what's the point if everything hinges on a single 
		server.</p>
	<strong>More features are coming soon so make sure to join us on 
		<a href="https://discord.gg/dKDuaST" target="_blank">Discord</a> 
		and meet all the other Archivonauts!</strong>
</div>
<br />
<div id="pin-card" class="card border-dark mb-3">
	<div class="card-header">
			<h3>Pin Content:</h3>
	</div>
	<div class="card-body">
	<form id="pin-form" action="#pin-card" method="GET">
		<div class="text-center">
			<h4>Steem Account<br />(without "@"):</h4>
			<input style="width:40%;text-align:center" class="pin-card" type="text" name="steemName" 
				placeholder="eg: jrswab" />
			<br /><br />
			<h4>Hash To Pin:</h4>
			<input style="width:80%;text-align:center" class="form-input" type="text" name="pinHash" 
				placeholder="eg: QmTFLiKypBp6RxA6L1XGDhtmMXK5DYpBnVxNcG4yp1HWVT" />
		</div>
		<br>
		
		<button id="pinClick" class="btn btn-secondary btn-lg 
			btn-block" name="pinSubmit" type="submit">Grab SteemConnect Link</button>

			<?php 
				// Build SteemConnect Link
				if (!empty($_GET['steemName'])) {
					$steemName = htmlspecialchars($_GET['steemName']);
				}

				if (!empty($_GET['pinHash'])) {
					$pinHash = htmlspecialchars($_GET['pinHash']);
				}

				$domain = htmlspecialchars($_SERVER['HTTP_HOST']);
				$info = array('to' => 'nebulus', 'from' => $steemName, 
					'amount' => '1.000 STEEM', 'memo' => 'pin '.$pinHash, 
					'redirect_uri' => 'https://'.$domain.'/welcome.php');
				$sc2Link = http_build_query($info);

				// make sure name and hash are in url
				if (!empty($_GET['steemName'] | $_GET['pinHash'])) {
					echo '<br /><br />
						<div class="text-center">
							<h4><a  
							href="https://steemconnect.com/sign/transfer?'.$sc2Link.'">
							Click here to send pin transaction with SteemConnect!</a></h4>
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
more than likely still proved the end user with a copy. Please keep this 
in mind when uploading and never upload anything you do not want to be online 
forever.</p>
	<p class="alert alert-warning"><strong>This is still a beta service!</strong> 
Please do not use this as a backup service. We are still in the early stages 
of Nebulus and don't want you to lose your data. Always save a copy on 
an external hard drive and a separate cloud service for redundancy.</p>
</form>

<h3>How To Use:</h3>
<div>
	<ol>
		<li>Create an account.</li>
		<li>Click "Select File"</li>
		<li>Click "Upload"</li>
		<li>Wait. The larger the file the longer it will take to upload so be patient.</li>
	</ol>
</div>

<p>For video content, we recommend 
<a href="https://handbrake.fr" target="_blank">HandBreak</a> it's a 
free and open-source video transcoder that lets the user input their 
original video and output a web-optimized version. This optimized version 
will not only upload faster with our service but will also have better 
playback for your viewers.</p>
	
	<p>Servers of this size are quite expensive; please consider donating 
STEEM or SBD to <a href="https://steemit.com/@jrswab">@jrswab</a> in order 
to keep this service running. Be sure to add a memo to let us know the 
donation is for this project and we'll add your name to the coming 
"supporters" page.</p>
	
	<p>Donations help show that you would like to see further development on 
this project. Some things we'd like to include:  user signups so you can 
save your hashes for future reference, better user experience, and 
SteemConnect integration.</p>
	
	<p>If you have a Steem account and find this service helpful please 
<a href="https://steemconnect.com/sign/account-witness-vote?witness=jrswab&approve=1" target="_blank">
	vote for @jrswab's witness server</a>. Every vote counts no matter how much Steem Power you hold.</p>
	
	<p>Join us on <a href="https://discord.gg/dKDuaST" target="_blank">Discord</a>!</p>
    
<?php include 'config/bottom.html'; ?>
