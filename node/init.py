#!/usr/bin/env python3

from beem import Steem
from beem.account import Account

# grab steem key
with open('/var/www/wifRaw', 'r') as wifRaw:
    wif=wifRaw.read().replace('\n', '')

# set up steem keys and account name
steem = Steem(keys=[wif])
account = Account("jrswab", steem_instance=steem)

# Send custom json init message
steem.custom_json('nebulus_node', '{"node": "initialized"}',
        required_posting_auths=[account["name"]])
