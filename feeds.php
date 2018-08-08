<?php
	include 'config/uploadDBconfig.php';

$dir = '';
while (!glob($dir.'hash.php')) {
	$dir .= '../';
}

	// tell php what type of content follows
	header("Content-Type: application/rss+xml; charset=UTF-8");

	// uso URI to grab username since user may not be logged in.
	$fullURI = $_SERVER['REQUEST_URI'];
	$URIArray = explode('/', $fullURI);
	$endURL = end($URIArray);
	$rawUser = prev($URIArray);
	$user = htmlspecialchars($rawUser);

	// Get the full path to user profile photo
	$proPho = shell_exec('ls '.$dir.'uploads/profiles/ | grep '.$user);

	// top of rss feed
	$rssfeed = '
	<?xml version="1.0" encoding="UTF-8" ?>
		<rss version="2.0">
		<channel>';

	// unchanging rss info
	$rssfeed .= '
			<title>'.$user.'\'s Nebulus Feed</title>
			<link>'.$dir.'u/'.$user.'</link>
			<description>This is the Nebulus RSS feed for '.$user.'</description>
			<image>
				<url>'.$dir.'uploads/profiles/'.$proPho.'</url>
				<title>'.$user.'\'s Nebulus Feed</title>
				<link>https://archivatory.com/u/'.$user.'</link>
			</image>
			<language>en-us</language>
			<copyright>Copyright (C) '.date("Y").' '.$user.'</copyright>';

	// query user data
	$sql = "SELECT * FROM ".$user." WHERE playlist=1 ORDER BY date DESC;";
	$result = mysqli_query($link, $sql);
	$resultCheck = mysqli_num_rows($result);

	if ($resultCheck > 0) {
		// loop through users' table and output into html table body	
		while ($row = mysqli_fetch_assoc($result)) { 
			$rssfeed .= '
			<item>
				<title>'.$row["title"].'</title>
				<link>https://ipfs.io/ipfs/'.$row["hash"].'</link>
				<description>'.$row["des"].'</description>
				<pubDate>'.$row["date"].'</pubDate>
			</item>';
		}
	}

	$rssfeed .= '
		</channel>
	</rss>';

echo $rssfeed;
?>
