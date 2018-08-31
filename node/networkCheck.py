#!/usr/bin/env python3

from beem.blockchain import Blockchain
from beem.block import Block

# set chain to the needed blockchain params
chain = Blockchain(steem_instance=None, mode='irreversible',
        max_block_wait_repetition=None, data_refresh_time_seconds=900)

def countNodes(name):
    syntax = '+ ' + name
    with open('config/nodeList', 'r') as count:
        nodes = count.readlines()

    if syntax in nodes:
        print("Node already in list")
    else:
        with open('nodeList', 'a') as nodeList:
            nodeList.write('\n+ ' + name)

def getStartBlock():
    try:
        # Look for an int in the specified file
        with open('config/startBlock', 'r') as startBlock:
            sBlock = startBlock.read().replace('\n', '')
    except FileNotFoundError:
        # if no file; assume new node and start at first init block
        sBlock = 25506548
    return sBlock

def setEndBlock():
    # save current block on run for next starting block
    eBlock = chain.get_current_block().block_num
    return eBlock

def setStartBlock(eBlock):
    with open('config/startBlock', 'w') as newStart:
        newStart.write(str(eBlock))

# set block variables
sBlock = int(getStartBlock())
eBlock = int(setEndBlock())

# write last block checked into a text file.
for operation in chain.stream(opNames=['custom_json'],
        raw_ops=False, start=sBlock, stop=eBlock):
    # print out of proper running confirmation
    print('Checking Block #'+ str(operation['block_num']))
    # grab all operations with 'nebulus_node' between start and stop
    if 'nebulus_node' in operation['id']:
        # grab all init claims
        if 'initialized' in operation['json']:
            name = str(operation['required_posting_auths'])
            # pass name for insertion into init list
            countNodes(name[2:-2])
        else:
            print("No new init found in this Nebulus Json")


setStartBlock(eBlock)

