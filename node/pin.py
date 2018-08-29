#!/usr/bin/env python
import subprocess
import time
import json
import sys
import os
import math
import random

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

# finds the hashes to be pinned
# pins if the turn in correct
def pin():
    # Loop through the past 1000 transactions for the account variable.
    for blocks in account.get_account_history(-1, 1000):
        # set block data into json format
        trx = json.dumps(blocks, sort_keys=True, indent=4, 
                separators=(',', ': '))
        # allows us to call data by the json key
        trxRaw = json.loads(trx)
        roundRobin = random.randint(0,9)
        if 'pin ' in trx:
            if priceCheck(trxRaw):
                print(roundRobin)
                if roundRobin % 2 == 0:
                    pHash = chainCheck(trxRaw)
                    print(pHash)
                    out = subprocess.call(
                            "/usr/local/bin/ipfs pin ls | grep '" +  pHash 
                            + "'", shell=True)
                    # create a function to skip to next if already pinned
                    if out == 1:
                        pgreped = pinAdd(pHash)
                        if pHash in pgreped:
                            pidKill(pgreped, pHash)
                else:
                    print("Skipping")
            else:
                print("Incorrect Amount of STEEM") 

# make sure the STEEM (or SBD) is the correct amount
def priceCheck(trxRaw):
    curr = trxRaw['amount'].split(" ")
    amount = curr[0].split(".")
    if 'STEEM' in curr[1]:
        if int(amount[0]) == 1:
            return True
        else:
            return False
    else:
        return False

# Grab the IPFS hash from the memo
def chainCheck(trxRaw):
    memo = trxRaw['memo']
    chain = memo.split()
    pHash = str(chain[1])
    return pHash


def pinAdd(pHash):
    # place holder for sending back payment
    if pHash is None:
        print("No hash found")
        return None
    else:
        cmd = "/usr/local/bin/ipfs pin add '" + pHash + "'"
        print("'" + str(cmd) + "'")
        pin = subprocess.Popen(cmd, shell=True)
        time.sleep(5)
        # n below tells pgrep to output the newest process starting with ipfs
        # add specific hash to pgrep
        pgreped = subprocess.check_output("pgrep -an '" + pHash + "'", shell=True)
        return pgreped


def pidKill(pgreped, pHash):
    # fail safe for not running pgreped in pinHash()
    if pgreped == 1 or pgreped == 2:
        print("Nothing to kill")
        return None
    else:
        pgrepSplit = pgreped.split(" ")
        pid = pgrepSplit[0]
        kill = subprocess.call("kill -9 '" + pid + "'", shell=True)
        print("Could not pin '" + pHash + 
                "' in alotted amount of time. Will try again later. Killed PID " 
                + pid + ".")


# Start execution
pin()

