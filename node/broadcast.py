#!/usr/bin/env python3

from beem import Steem
from beem.account import Account

# grab private key
with open('/var/www/wifRaw', 'r') as wifRaw:
    wif=wifRaw.read().replace('\n', '')

# set up steem key and account
steem = Steem(
        nobroadcast=False, # set to true for testing
        keys=[wif]
)

acc = Account('jrswab', steem_instance=steem)

# get pinned hashes
with open('hashList', 'r') as hashList:
    hashes = hashList.read().split('\n')

# send custom json with hashes
print(steem.custom_json('nebulus_req', '{"hashes": ' 
    + ', '.join(hashes) + '"}', 
    required_posting_auths=[acc['name']]))
