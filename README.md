## Nebulus
### Set Us As A Peer!
In order to keep Nebulus from becoming just another "holder-of-files" make sure to set us as one of your IPFS peers:
`ipfs swarm connect /ip4/139.99.131.59/tcp/6537/ipfs/QmYUTAbwZWck3LW9XZBcHTz2Jaip3mGfYDt3LTXdPLEh23`

## Setting up a Nebulus Node:
Docker file comming soon!

If you want to run a node in the mean time contact J. R. Swab:

Discord `@jrswab#3134`, Tox: `jrswab@toxme.io`, or XMPP: `jrswab@kode.im`.

This will help find the pain points during setup and assist in the Docker creation.
### Dependencies:
- Linux
  - There has been no testing outside of Ubuntu 16.04
  - Feel free to test and send updates on another OS.
- Python
- Pip
  - BEEM

### Full setup script is in the works.
#### Configure IPFS
```bash
# Set up ipfs
ipfs init 2>&1

# Tell IPFS not to use local network discovery
ipfs config --json Discovery.MDNS.Enabled false 2>&1

# Set IPFS to filter out common local IP addresses
ipfs config --json Swarm.AddrFilters '[
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
]' 2>&1

```
You may also need to change your IPFS ports to limit throttleing from your IPFS.
#### Run IPFS daemon
```bash
# IPFS_FD_MAX=4096 is optional
IPFS_FD_MAX=4096 ipfs daemon &
```
