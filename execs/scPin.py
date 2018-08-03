import sys

from beem import Steem
from beem.account import Account
from beem.steemconnect import SteemConnect

# set nobroadcast always to True, when testing
steem = Steem(
    nobroadcast=True, # Set to false when want to go live
    unsigned=True
)

# Set varialbe to steemconnect instance
sc2 = SteemConnect(steem_instance=steem)

# Get arguments
user = sys.argv[1]
pinMemo = sys.argv[2]

# Set account sender
acc = Account(user, steem_instance=steem)

# Return url
print(sc2.url_from_tx(
    acc.transfer("nebulus", 1, "STEEM", pinMemo))
)
