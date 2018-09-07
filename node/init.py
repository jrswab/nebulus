#!/usr/bin/env python3

from beem import Steem
from beem.account import Account

# needed to form user data dictionary
userFormat = ['user', 'wifLocation']

# grab steem user data
with open('config/userData', 'r') as userData:
    steemInfo = dict(zip(userFormat,userData.read().splitlines()))

# get private posting key from location
with open(steemInfo['wifLocation'], 'r') as wifRaw:
    wif = wifRaw.read().replace('\n', '')

# set up steem keys and account name
steem = Steem(keys=[wif])
account = Account(steemInfo['user'], steem_instance=steem)

# Send custom json init message
steem.custom_json('nebulus_node', '{"node": "initialized"}',
        required_posting_auths=[account["name"]])
