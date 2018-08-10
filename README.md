## Nebulus
### How to use:
1. Head over to https://nebulus.app
2. Click "Choose File"
3. Click "Upload"
4. Wait for the file to upload
5. Save the hash and link (user accounts save the hashes automatically!)

### Set Us As A Peer!
In order to keep Nebulus from becoming just another "holder-of-files" make sure to set us as one of your IPFS peers:
`ipfs swarm connect /ip4/139.99.131.59/tcp/6537/ipfs/QmYUTAbwZWck3LW9XZBcHTz2Jaip3mGfYDt3LTXdPLEh23`

## Setting Up Your Own Nebulus:
### Dependencies:
- Linux
- Apache
- MySQL
- PHP
- Python
- Pip
  - BEEM
### Set Up A LAMP Server:
For a great guide check out [Digital Ocean](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04)
### Configure Your php.ini file:
1. Head to /etc/php/7.0/apache2/ (Ubutnu 16.04)
2. Open php.ini in your text editor of choice.
3. Change the following:
  - `post_max_size` set to 0 for unlimited or choose a limit.
	- `upload_max_size` set to the max allowed upload for your instance.
	- `memory_limit` If running a server that only has an Nebulus instance do not set this higher that half of your total server RAM. This tells PHP how much RAM it is allowed to hog.
	- `max_execution_time` Limits the execution time per script. Large files may need more run time.
	- For more information on these settings see [PHP: Handling file upload - Common Pitfalls](http://www.php.net/manual/en/features.file-upload.common-pitfalls.php).

### Create Databases and Tables:
`mysql -u root -p`
```
CREATE DATABASE archivatory;

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE DATABASE archivatoryUploads;
```

*Table creation in `archivatoryUploads` is done in the `memUp.php` script*

### Add config/congfig.php & config/uploadDBconfig.php
These two file are needed in order to have the site talk to your databases. They are not included in the package as of June 28th, 2018 to avoid confusion between development and production servers.
#### config.php

```
<?php
/* Database credentials. Assuming you are running MySQL */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_NAME', 'archivatory');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

```
#### uploadDBconfig.php

```
<?php
// Database credentials.
$dbServerName = "localhost";
$dbUsername = "";
$dbPassword = "";
$dbName = "archivatoryUploads";
 
// Attempt to connect to MySQL database 
$link = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
```
### Full setup script is in the works.
#### Tell Apache Where the IPFS PATH is Located:
You should move your IPFS_PATH to /var/www/.ipfs/ after installing go-ipfs.
`export IPFS_PATH=/var/www/.ipfs/`
Do this before your have Apache run `ipfs init 2>&1`
However, just running it as a user or root may not be enough. If you find that
apache still can not init then you have to add the export line to /etc/apache2/envnars`.

##### On Ubuntu Server 16.04:
1. `sudo vim /etc/apache2/envvars`
2. Add `export IPFS_PATH=/var/www/.ipfs/` to the end of the file.
3. Save and exit.
4. Run `sudo systemctl restart apache2 && sudo systemctl status apache2`
5. Test init with `<?php ipfs init 2>&1 ?>` as init.php

#### Configure IPFS
```
<?php
// have apache set up ipfs
$initIPFS = shell_exec("ipfs init 2>&1");

// Tell IPFS not to use local network discovery
$mdnOff = shell_exec("ipfs config --json Discovery.MDNS.Enabled false 2>&1");

// Set IPFS to filter out common local IP addresses
$filterIPFS = shell_exec("ipfs config --json Swarm.AddrFilters '[
	\"/ip4/10.0.0.0/ipcidr/8\",
	\"/ip4/100.64.0.0/ipcidr/10\",
	\"/ip4/169.254.0.0/ipcidr/16\",
	\"/ip4/172.16.0.0/ipcidr/12\",
	\"/ip4/192.0.0.0/ipcidr/24\",
	\"/ip4/192.0.0.0/ipcidr/29\",
	\"/ip4/192.0.0.8/ipcidr/32\",
	\"/ip4/192.0.0.170/ipcidr/32\",
	\"/ip4/192.0.0.171/ipcidr/32\",
	\"/ip4/192.0.2.0/ipcidr/24\",
	\"/ip4/192.168.0.0/ipcidr/16\",
	\"/ip4/198.18.0.0/ipcidr/15\",
	\"/ip4/198.51.100.0/ipcidr/24\",
	\"/ip4/203.0.113.0/ipcidr/24\",
	\"/ip4/240.0.0.0/ipcidr/4\"
]' 2>&1");

// Checking for execution of above commands
echo $initIPFS;
if ($mdnOff) {
				echo "MDNS Disabled.";
}
if ($filterIPFS) {
				echo "Swarm filter added.";
}
```

#### Run IPFS as Apache
`<?php shell_exec("IPFS_FD_MAX=4096 ipfs daemon &"); ?>`
