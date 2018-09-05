#!/usr/bin/env python3

import subprocess
import time
import random

# To escape shell strings
from shlex import quote

# BEEM modules
from beem.account import Account

# sent Nebulus account
acc = Account("nebulus")

# TODO: Change to be $1 usd worth of steem
# instead of one steem.
def priceCheck(amount):    
    chainData = amount.split()
    total = float(chainData[0])
    # make sure correct currency was sent
    if 'STEEM' in chainData[1]:
        if total >= 1:
            return True
        else:
            return False
    else:
        return False

def randNum():
    return random.randint(0, 100)

# get IPFS hash from the transfer memo
def getHash(memo):
    ipfsHash = memo.split()
    return ipfsHash[1]

# look for hash in server
def hashCheck(ipfsHex):
    return subprocess.call('/usr/local/bin/ipfs pin ls | grep '
        + format(quote(ipfsHex)), shell=True)

def findPID():
    pgrep = subprocess.check_output('pgrep -an ipfs', shell=True)
    return str(pgrep.split()[0]).split('\'')

def kill(pid):
    kill = pid[1]
    subprocess.call('kill -9 ' + format(quote(kill)), shell=True)

for blocks in acc.get_account_history(-1, 500):
    # skip any block without these parameters
    if 'transfer' in blocks['type'] and 'pin ' in blocks['memo']:
        if priceCheck(blocks['amount']):
            # to keep all nodes from filling up at the same rate
            if randNum() % 2 == 0:
                # set current memo hash to variable
                currHash = getHash(blocks['memo'])
                # hashCheck == 1 tells us that the hash was not found
                if hashCheck(currHash) == 1:
                    pin = subprocess.Popen('/usr/local/bin/ipfs pin add ' +
                        format(quote(currHash)), shell=True)
                    # give ipfs time to pin hash (in seconds)
                    # TODO: change amout for prod.
                    time.sleep(6)
                    # ipfs returns '0' when successful
                    if pin == 0:
                        # if pinned write hash to file
                        with open('pinnedList', 'a') as list:
                            list.write(currHash)
                    else:
                        # kill pin process if still running
                        kill(findPID())
