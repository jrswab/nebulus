import os
import sys
import subprocess

arg = sys.argv[1]

subprocess.popen("ipfs pin add  " + arg + " > /dev/null 2>&1 &")
print(arg)
sys.exit(0)
