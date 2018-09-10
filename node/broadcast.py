#!/usr/bin/env python3

from beem import Steem
from beem.account import Account

# needed to form dictionary from userData
userFormat = ['user', 'wifLocation']

# get steem user data
with open('config/userData', 'r') as userData:
    steemInfo = dict(zip(userFormat,userData.read().splitlines()))

# grab wif
with open(steemInfo['wifLocation'], 'r') as wifRaw:
    wif = wifRaw.read().replace('\n', '')

# set up steem key and account
steem = Steem(
        nobroadcast=False, # set to true for testing
        keys=[wif]
)

# set acc to the steem account in config/steemAcc
acc = Account(steemInfo['user'], steem_instance=steem)

# get pinned hashes
with open('hashList', 'r') as hashList:
    hashes = hashList.read().split('\n')

# send custom json with hashes
steem.custom_json('nebulus_req', '{"hashes": ' 
    + ', '.join(hashes) + '"}', 
    required_posting_auths=[acc['name']])
