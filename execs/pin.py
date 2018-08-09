#!/usr/bin/env python

import json
import sys
import os

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

# set the arugment to pinHash
#pinHash = sys.argv[1]

# Loop through the past 50 transaction for the account variable.
# Keeping it to 50 allows for a faster load time
# while still having good coverage
# may need to increase as user adoption increases
for blocks in account.get_account_history(-1,50):
    # set block data into json format
    trx = json.dumps(blocks, sort_keys=True, indent=4, separators=(',', ': '))
    # allows us to call data by the json key
    trxRaw = json.loads(trx)

    if 'pin' in trx:
	memo = trxRaw["memo"]
	chain = memo.split()
	print(chain[1])
