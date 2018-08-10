#!/usr/bin/env python
import subprocess
import time
import json
import sys
import os
import math

# Steem Access
from beem import Steem
from beem.account import Account
from beem.instance import set_shared_steem_instance
from beem.blockchain import Blockchain

# grab acount private key
with open('/var/www/wifRaw', 'r') as wifRaw:
    wif=wifRaw.read().replace('\n', '')
    
# set nobroadcast always to True, when testing
steem = Steem(
    nobroadcast=False, # Set to false when want to go live
    keys=[wif],
)
# Set steem() as shared instance
set_shared_steem_instance(steem)

# Account to look up data
account = Account("nebulus")

# Set the number of blocks to iterate over
blockNum = 50

# Global round robin count
roundRobin = 0

def robin(blockNum):
    global roundRobin
    # Loop through the past 'blockNum' transaction for the account variable.
    # Keeping it to 50 allows for a faster load time
    # while still having good coverage
    # may need to increase as user adoption increases
    for blocks in account.get_account_history(-1, blockNum):
        # set block data into json format
        trx = json.dumps(blocks, sort_keys=True, indent=4, separators=(',', ': '))
        # allows us to call data by the json key
        trxRaw = json.loads(trx)

        if 'init' in trx:
            roundRobin += 1

    roundRobin = math.ceil((roundRobin / 3) + 1)
    return roundRobin

def pin(roundRobin, blockNum):
    # Loop through the past 'blockNum' transaction for the account variable.
    # Keeping it to 50 allows for a faster load time
    # while still having good coverage
    # may need to increase as user adoption increases
    for blocks in account.get_account_history(-1, blockNum):
        # set block data into json format
        trx = json.dumps(blocks, sort_keys=True, indent=4, separators=(',', ': '))
        # allows us to call data by the json key
        trxRaw = json.loads(trx)
        if roundRobin == 1 or roundRobin % 2 == 0:
            if 'pin' in trx:
                pHash = chainCheck(trxRaw)
                out = subprocess.call("ipfs pin ls | grep '" +  pHash + "'", shell=True)
                if out == 1:
                    pgreped = pinAdd(pHash)
                    if pHash in pgreped:
                        pidKill(pgreped, pHash)
                    else:
                       print("Pinned")
                else:
                    print(pHash + " already pinned")

def chainCheck(trxRaw):
    memo = trxRaw["memo"]
    chain = memo.split()
    pHash = str(chain[1])
    return pHash


def pinAdd(pHash):
    cmd = "ipfs pin add '" + pHash + "'"
    pin = subprocess.Popen(cmd, shell=True)
    time.sleep(10)
    # n below tells pgrep to output the newest process starting with ipfs
    pgreped = subprocess.check_output("pgrep -an ipfs", shell=True)
    return pgreped


def pidKill(pgreped, pHash):
    pgrepSplit = pgreped.split(" ")
    pid = pgrepSplit[0]
    kill = subprocess.call("kill -9 '" + pid + "'", shell=True)
    print("Could not pin '" + pHash + 
            "' in alotted amount of time. Will try again later. Killed PID " 
            + pid + ".")


# Start execution
robin(blockNum)
pin(roundRobin, blockNum)
