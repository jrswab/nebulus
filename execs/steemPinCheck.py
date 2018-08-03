import json

from beem import Steem
from beem.account import Account
from beem.instance import set_shared_steem_instance
from beem.blockchain import Blockchain

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

# Loop through the past 1,000 transaction for the account variable.
for blocks in account.get_account_history(-1,1000):
    trx = json.dumps(blocks, sort_keys=True, indent=4, separators=(',', ': '))
    trxRaw = json.loads(trx)
    if 'transfer' and 'pin' in trx:
        ipfsHash = trxRaw["memo"]
        print(ipfsHash + "'")
