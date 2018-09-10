<?php include 'config/top.php'; ?> 
	<h2>Welcome to Nebulus.</h2>
	<p>
	Nebulus is a Python-based project that gives the content creator a place to 
	"backup" media within the Interplanetary File System (IPFS). The more areas 
	your content exists, the better the chance that your work will be available 
	whenever a viewer wishes to consume your media. The idea for this service 
	spun out of the developer's desire to help the decentralized apps (dapps) on STEEM 
	to better compete with their centralized counterparts.
	</p>

	<p>
	After chatting with a few Steemians (cryptocurrency earing content creators), 
	it was clear that the developer was not the only one looking for a way to 
	keep their media alive. We are still a very new project with lots of milestones 
	we what to reach to provide as much value for "Nebunauts" all around the galaxy.
	</p>

	<p>
	Nebulus is a federated service this means that there is not just one server 
	"backing up" your media. This is important to keep the dapps decentralized 
	because what's the point if everything hinges on a single server.
	</p>
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
			<input style="width:40%;text-align:center" class="pin-card" type="text"
				name="steemName" placeholder="eg: jrswab" />
			<br /><br />
			<h4>Hash To Pin:</h4>
			<input style="width:80%;text-align:center" class="form-input" type="text" 
				name="pinHash" 
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
		<li>Enter your Steem account</li>
		<li>Enter you IPFS hash</li>
		<li>Click the button</li>
		<li>Click the generated SteemConnect link</li>
	</ol>
</div>

<h4>Why does this cost STEEM?</h4>
<p>
Because the servers are quite expensive. We also pay out a portion of the cost 
to the nodes on our network that save your media to their server, so your 
content stays alive. They give up their hard drive space to keep the Dapps as 
decentralized as possible and we want to reward them for that.
</p>
<p>
Until we get the Dapps to support their users content by sending the pin requests, 
the creator will have to fork the cost of the donation. The price will never go 
above one USD worth of STEEM to keep it accessible to all creators no matter their 
level of success.
</p>
<p>
Donations of STEEM or SBD to the @nebulus Steem account will help keep this 
service running. Be sure to add a memo to let us know the gift is for this project 
and we'll add your name to the coming "supporters" page. Donations help show that 
you would like to see further development on this project.
</p>
	
<p>Join us on <a href="https://discord.gg/dKDuaST" target="_blank">Discord</a>!</p>
    
<?php include 'config/bottom.html'; ?>
