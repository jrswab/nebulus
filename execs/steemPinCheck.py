import json
import logging
log = logging.getLogger(__name__)
logging.basicConfig(level=logging.INFO)

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
# Set testnet as shared instance
set_shared_steem_instance(steem)

# Account will use now testnet
account = Account("nebulus")

# Loop through the past 1,000 transaction for the nebulus account.
for blocks in account.get_account_history(-1,1000):
    trx = json.dumps(blocks, sort_keys=True, indent=4, separators=(',', ': '))
    trxRaw = json.loads(trx)
    if 'transfer' and 'pin' in trx:
        ipfsHash = trxRaw["memo"]
        print(ipfsHash + "'")
