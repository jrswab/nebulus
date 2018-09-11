#!/usr/bin/env python3

print('Enter Your Steem Account Name')
steemName = input()
print('Enter the location of your private posting key')
wif = input()

with open('config/userData', 'w') as userData:
    userData.write(steemName + '\n' + wif)

